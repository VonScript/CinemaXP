<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movie extends CXP_Controller
{
	// This is the folder path all text will upload to.
	var $text_folder = 'uploads/movies/text';

	// This is the folder path all text will upload to.
	var $images_folder = 'uploads/movies/images';

	// Load the necessary libraries
	function __construct()
	{
		parent::__construct();

		// load the libraries after the code has been set.
		$this->load->model('movie_model');
		$this->load->helper('file');
	}

	public function index()
	{
		$allmovies = [
			'movies'	=> $this->movie_model->get_cinema_movies()
		];

		$data = [];
		$allsets = [];

		foreach($allmovies as $am){
			foreach($am as $set){

			$set['text'] = read_file("{$this->text_folder}/{$set['movie_id']}.txt");
			$set['image'] = $this->_get_image_path($set['movie_id']);

			array_push($allsets, $set);
			}
		}

		$data = [
			'movies'	=> $allsets
		];

			$this->build('movie/index', $data);
	}

	public function bookseats($submit = FALSE){
		if ($submit !== FALSE)
		{
			return $this->_do_booking();
		}

		$this->load->library(['user_agent' => 'ua']);

		$data = [
			'movie'			=> $this->movie_model->get_cinema_movies(),
			'showtimes'	=> $this->movie_model->get_showtimes(),
			'columns'			=> $this->movie_model->get_columns(),
			'rows'			=> $this->movie_model->get_rows()
		];

		$this->build('movie/bookseats', $data);
	}

	public function _do_booking(){
		 $form_data = $this->input->post();
		 // 1. Load the form_validation library.
		 $this->load->library(['form_validation' => 'fv']);

		 // 2. Set the validation rules.
		 $this->fv->set_rules([
			 [
				 'field'	=> 'movie-viewing',
				 'label'	=> 'Movie',
				 'rules' => 'required'
			 ],
			 [
				 'field'	=> 'movie-showtime',
				 'label'	=> 'Showtime',
				 'rules' => 'required'
			 ],
			 [
				 'field'	=> 'movie-seats[]',
				 'label'	=> 'Seats',
				 'rules' => 'required'
			 ]
		 ]);

		 // 3. If the validation failed, we'll reload.
		 if ($this->fv->run() === FALSE)
		 {
			 return $this->bookseats();
		 }

		 // 4. Get the inputs from the form.
		 $movie_id			= $this->input->post('movie-viewing');
		 $showtime			= $this->input->post('movie-showtime');
		 $seats 			= $this->input->post('movie-seats');
		 $user_id			= $this->input->post('user_id');

		 // 5. Try to insert the data in its tables, and get back the ID.
		 $booking_id = $this->movie_model->create_booking($user_id, $movie_id, $showtime, $seats);
		 if ($booking_id === FALSE)
		 {
			 exit("Your booking could not be completed. Please go back and try again.");
		 }

		 redirect('movie/ticket/'.$booking_id);
	}

	public function ticket($ticket_id){
		$data = [
			'ticket'	=> $this->movie_model->get_ticket($ticket_id),
			'seats'		=> $this->movie_model->get_booked_seats($ticket_id)
		];

			$this->build('movie/ticket', $data);
	}

	public function create($submit = FALSE)
	{
		// If submit is not FALSE, we'll try checking the form.
		if ($submit !== FALSE)
		{
			return $this->_do_create();
		}

		// loads the user-agent library to identify platform/browser.
		$this->load->library(['user_agent' => 'ua']);

		$data = [
			'ratings'			=> $this->movie_model->get_ratings(),
			'categories'	=> $this->movie_model->get_categories_array(),
			'platform'		=> strtolower($this->ua->platform())
		];

		$this->build('movie/create', $data);
	}

	public function delete($slug = NULL)
	{
		// Check if the movie exists, and if it does
		// assign it to a variable.
		if (!$movie = $this->movie_model->get_movie($slug))
		{
			show_404();
		}

		// Start by deleting the files for this movie.
		$path = "{$this->text_folder}/{$movie['id']}.txt";
		if (file_exists($path)) unlink($path);

		// Delete the file and redirect.
		$this->movie_model->delete_movie($slug);

		redirect('movie');
	}

	public function edit($slug = NULL, $submit = FALSE)
	{
		// Check if the movie exists, and if it does
		// assign it to a variable.
		if (!$movie = $this->movie_model->get_movie($slug))
		{
			show_404();
		}

		// Check that the form was sent, if so do another process.
		if ($submit !== FALSE)
		{
			return $this->_do_edit($movie);
		}

		// loads the user-agent library to identify platform/browser.
		$this->load->library(['user_agent' => 'ua']);

		$movie['text'] = read_file("{$this->text_folder}/{$movie['id']}.txt");
		$movie['categories'] = $this->movie_model->get_movie_categories($movie['id']);
		$movie['image'] = $this->_get_image_path($movie['id']);

		$data = [
			'movie'		=> $movie,
			'ratings'		=> $this->movie_model->get_ratings(),
			'categories'	=> $this->movie_model->get_categories_array(),
			'platform'		=> strtolower($this->ua->platform())
		];

		$this->build('movie/edit', $data);
	}

	public function movielist(){
		$data = [
			'movies'	=> $this->movie_model->get_movies(),
			'cinemas' => $this->movie_model->get_cinemas()
		];

		$this->build('movie/movielist', $data);
	}

	public function change_cinemas(){
			$cinema_movies = $this->input->post('cinema_movie') ?: [];

			if(count($cinema_movies) > 0){
				foreach($cinema_movies as $cm){
					$cinema_id = substr($cm, 0, 1);
					$movie_id = substr($cm, 1);
					echo "Cinema : ".$cinema_id;
					echo "Movie : ".$movie_id;

					if(!$this->movie_model->assign_cinema($cinema_id, $movie_id)){
						echo "Something went wrong. ".$cinema_id." - ".$movie_id;
					}
				}
			}

			redirect('movie/movielist');
	}

	public function view($slug){
		if (!$movie = $this->movie_model->get_movie($slug))
		{
			show_404();
		}
		$results = [];
		$categories = "";

		$movie['text'] = read_file("{$this->text_folder}/{$movie['id']}.txt");
		$results = $this->movie_model->get_movie_categories($movie['id']);
		foreach($results as $cat){
			$one = $this->movie_model->get_category($cat);
			$categories = $categories . $one['name'] . " ";
		}
		$movie['categories'] = $categories;
		$movie['image'] = $this->_get_image_path($movie['id']);

		$data = ['movie' => $movie];

		$this->build('movie/view', $data);
	}

	// Process the creation form.
	private function _do_create()
	{
		// 1. Load the form_validation library.
		$this->load->library(['form_validation' => 'fv']);

		// 2. Set the validation rules.
		$this->fv->set_rules([
			[
				'field'	=> 'movie-title',
				'label'	=> 'Title',
				'rules' => 'required|min_length[5]'
			],
			[
				'field'	=> 'movie-release-date',
				'label'	=> 'Release Date',
				'rules' => 'required'
			],
			[
				'field'	=> 'movie-rating',
				'label'	=> 'Rating',
				'rules' => 'required'
			],
			[
				'field'	=> 'movie-actors',
				'label'	=> 'Actors',
				'rules' => 'required'
			],
			[
				'field'	=> 'movie-writers',
				'label'	=> 'Writers',
				'rules' => 'required'
			],
			[
				'field'	=> 'movie-directors',
				'label'	=> 'Directors',
				'rules' => 'required'
			],
			[
				'field'	=> 'movie-text',
				'label'	=> 'Content',
				'rules' => 'required|min_length[50]'
			],
			[
				'field'	=> 'movie-image',
				'label' => 'Image',
				'rules' => 'file_required|file_allowed_type[gif,png,jpg]'
			]
		]);

		// 3. If the validation failed, we'll reload.
		if ($this->fv->run() === FALSE)
		{
			return $this->create();
		}

		// 4. Get the inputs from the form.
		$title						= $this->input->post('movie-title');
		$release_date			= $this->input->post('movie-release-date');
		$rating						= $this->input->post('movie-rating');
		$actors						= $this->input->post('movie-actors');
		$writers					= $this->input->post('movie-writers');
		$directors				= $this->input->post('movie-directors');
		$text							= $this->input->post('movie-text');
		$price						= "€6.50";
		$categories 			= $this->input->post('movie-categories') ?: [];

		// 5. Try to insert the data in its tables, and get back the ID.
		$movie_id = $this->movie_model->create_movie($title, $release_date, $rating, $actors, $writers, $directors, $price, $categories);
		if ($movie_id === FALSE)
		{
			exit("Your movie could not be posted. Please go back and try again.");
		}

		// 6. If the folder path is missing, create it.
		$this->_build_dir($this->text_folder);
		if (!write_file("{$this->text_folder}/{$movie_id}.txt", $text))
		{
			// delete the record.
			exit("Your movie could not be posted. Please go back and try again.");
		}

		$this->_upload_image($movie_id);

		redirect('movie');
	}

	// Process for the edit form.
	private function _do_edit($movie)
	{
		// 1. Load the form_validation library.
		$this->load->library(['form_validation' => 'fv']);

		// 2. Set the validation rules.
		$rules = [
			[
				'field'	=> 'movie-title',
				'label'	=> 'Title',
				'rules' => 'required|min_length[5]'
			],
			[
				'field'	=> 'movie-release-date',
				'label'	=> 'Release Date',
				'rules' => 'required'
			],
			[
				'field'	=> 'movie-rating',
				'label'	=> 'Rating',
				'rules' => 'required'
			],
			[
				'field'	=> 'movie-actors',
				'label'	=> 'Actors',
				'rules' => 'required'
			],
			[
				'field'	=> 'movie-writers',
				'label'	=> 'Writers',
				'rules' => 'required'
			],
			[
				'field'	=> 'movie-directors',
				'label'	=> 'Directors',
				'rules' => 'required'
			],
			[
				'field'	=> 'movie-text',
				'label'	=> 'Content',
				'rules' => 'required|min_length[50]'
			]
		];

		// if a file was uploaded, we'll add the rules to the array.
		if ($_FILES['movie-image']['name'] != '')
		{
			$rules[] = [
				'field'	=> 'movie-image',
				'label'	=> 'Image',
				'rules' => 'file_allowed_type[gif,jpg,png]'
			];
		}

		$this->fv->set_rules($rules);

		// 3. If the validation failed, we'll reload.
		if ($this->fv->run() === FALSE)
		{
			return $this->edit($movie['slug']);
		}

		// 4. Get the inputs from the form.
		$title						= $this->input->post('movie-title');
		$release_date			= $this->input->post('movie-release-date');
		$rating						= $this->input->post('movie-rating');
		$actors						= $this->input->post('movie-actors');
		$writers					= $this->input->post('movie-writers');
		$directors				= $this->input->post('movie-directors');
		$text							= $this->input->post('movie-text');
		$categories 			= $this->input->post('movie-categories') ?: [];

		// 5. Check if anything has changed in the form.
			// change the entry in the database.
			if (!$this->movie_model->update_movie($movie['id'], $title, $release_date, $rating, $actors, $writers, $directors))
			{
				exit("Your movie could not be edited. Please go back and try again.");
			}

		if (!$this->movie_model->replace_categories($movie['id'], $categories))
		{
			exit("Your movie could not be edited. Please go back and try again.");
		}

		// 6. If the folder path is missing, create it.
		$this->_build_dir($this->text_folder);
		if (!write_file("{$this->text_folder}/{$movie['id']}.txt", $text))
		{
			// delete the record.
			exit("Your movie could not be posted. Please go back and try again.");
		}

		$this->_build_dir($this->images_folder);
		if ($_FILES['movie-image']['name'] != '') $this->_upload_image($movie['id']);
		redirect('movie');
	}

	// Checks that the folder exists, creates it if not.
	private function _build_dir($dir)
	{
		// we don't need to do anything if the folder exists.
		if (file_exists($dir)) return;

		$segments = explode('/', $dir);
		$path = '';

		while (count($segments) > 0)
		{
			// array_shift -> removes the first element from $segments
			// and returns it as a string.
			$path .= array_shift($segments) . '/';
			if (!file_exists($path)) mkdir($path);
		}
	}

	// Uploads an image to a specific folder using the movie id as name.
	private function _upload_image($name)
	{
		// Since we're using this function for the movie edit page,
		// we also need to delete the existing files first.
		$files = glob("{$this->images_folder}/{$name}.*");
		foreach ($files as $file) unlink($file);

		// Create the images folder if it doesn't exist.
		$this->_build_dir($this->images_folder);

		// Set up the configuration for this file upload.
		$config['upload_path']			= $this->images_folder;
		$config['file_name']			= $name;
		$config['allowed_types']		= 'gif|jpg|png';
		$config['file_ext_tolower']		= TRUE;

		// Load the upload library and set its configuration.
		$this->load->library('upload');
		$this->upload->initialize($config);

		// Check if the file has uploaded, and show an error if not.
		if (!$this->upload->do_upload('movie-image'))
		{
			exit($this->upload->display_errors());
		}
	}

	// Looks for an image with a particular ID and returns the path.
	private function _get_image_path($id, $to_array = FALSE)
	{
		// Use glob to get all the images matching this name.
		$files = glob("{$this->images_folder}/{$id}.*");
		if ($to_array) return $files;

		if (count($files) > 0) return $files[0];
		return '';
	}
}
