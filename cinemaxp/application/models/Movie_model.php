<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Movie_model extends CI_Model
{
public function create_movie($title, $release_date, $rating, $actors, $writers, $directors, $price, $categories){

        // Create a slug from the title, and make sure we have categories.
        $slug = url_title($title, 'dash', TRUE);
        if ($categories == NULL) $categories = [];

        // Transactions will make queries temporary unless committed.
        // Queries will not work between start and complete.
        $this->db->trans_start();

            // Start with inserting the movie.
            $movies = [
                'title'     => $title,
                'slug'      => $slug,
                'release_date' => $release_date,
                'rating'  => $rating,
                'actors' => $actors,
                'writers'  => $writers,
                'directors' => $directors,
                'price' => $price
            ];
            $this->db->insert('tbl_movies', $movies);
            $insert_id = $this->db->insert_id();

            // Multiple categories can be chosen, we'll need to loop.
            if (count($categories) > 0)
            {
                $inserts = [];
                foreach ($categories as $cat)
                {
                    $inserts[] = [
                        'movie_id'    => $insert_id,
                        'category_id'   => $cat
                    ];
                }
                $this->db->insert_batch('tbl_movie_category', $inserts);
            }

        // The querying is done.
        $this->db->trans_complete();

        // If the query was not successful, we won't register
        // anything on the database.
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return $insert_id;
        }
    }

    public function assign_cinema($cinema_id, $movie_id){
      $this->db->where('id', $cinema_id)
              ->update('tbl_cinemas', [
                  'movie_id' => $movie_id
              ]);

      return $this->db->affected_rows() == 1;
    }

    // Creates an movie and assigns its categories.
    public function create_booking($user_id, $movie_id, $showtime, $seats)
    {
        if ($seats == NULL){
          return FALSE;
        };

        // Transactions will make queries temporary unless committed.
        // Queries will not work between start and complete.
        $this->db->trans_start();

            // Start with inserting the movie.
            $booking = [
                'user_id'     => $user_id,
                'cinema_id'      => substr($movie_id, 0, 1),
                'movie_id' => substr($movie_id, 1),
                'showtime_id' => $showtime
            ];
            $this->db->insert('tbl_bookings', $booking);
            $ticket_id = $this->db->insert_id();

            if (count($seats) > 0)
            {
                foreach ($seats as $seat)
                {
                    $inserts = [
                        'booking_id' => $ticket_id,
                        'row_id'    => substr($seat, 0, 1),
                        'col_id'   => substr($seat, 1)
                    ];
                    $this->db->insert('tbl_booked_seats', $inserts);
                }
            }

        // The querying is done.
        $this->db->trans_complete();

        // If the query was not successful, we won't register
        // anything on the database.
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return $ticket_id;
        }
    }

    public function get_ticket($ticket_id){
      return $this->db->select('b.name, c.title, d.showtime')
                      ->join('tbl_cinemas b', 'b.id = a.cinema_id', 'left')
                      ->join('tbl_movies c', 'c.id = a.movie_id', 'left')
                      ->join('tbl_showtimes d', 'd.id = a.showtime_id', 'left')
                      ->get_where('tbl_bookings a', ['a.id' => $ticket_id])
                      ->row_array();
    }

    public function get_booked_seats($ticket_id){
      return $this->db->select('b.seat_row, c.seat_column')
                      ->join('tbl_seat_rows b', 'b.id = a.row_id', 'left')
                      ->join('tbl_seat_columns c', 'c.id = a.col_id', 'left')
                      ->get_where('tbl_booked_seats a', ['booking_id' => $ticket_id])
                      ->result_array();
    }


    // Deletes an movie from the database.
    public function delete_movie($slug)
    {
        $this->db->delete('tbl_movies', ['slug' => $slug]);
    }

    public function get_cinemas(){
      return $this->db->get('tbl_cinemas')
                  ->result_array();
    }

    public function get_cinema_movies(){
      return $this->db->select('a.id, a.name AS cinema, a.movie_id, b.title, b.slug, b.price')
                      ->join('tbl_movies b', 'b.id = a.movie_id', 'left')
                      ->get('tbl_cinemas a')
                      ->result_array();
    }

    public function get_columns(){
      return $this->db->select('id, seat_column AS info')
                      ->get('tbl_seat_columns')
                      ->result_array();
    }

    public function get_rows(){
      return $this->db->select('id, seat_row AS info')
                      ->order_by('seat_row','desc')
                      ->get('tbl_seat_rows')
                      ->result_array();
    }

    public function get_showtimes(){
      return $this->db->select('id, showtime AS info')->get('tbl_showtimes')->result_array();
    }

    // Retrieves a single movie from the database.
    public function get_movie($slug)
    {
        return $this->db->select('*')
                    ->get_where('tbl_movies', ['slug' => $slug])
                    ->row_array();
    }

    // Retrieves movies from the database.
    public function get_movies()
    {
        return $this->db->select('a.id, a.title, a.slug, b.id as cinema_id, b.name, b.movie_id')
                        ->order_by('b.id')
                        ->join('tbl_cinemas b', 'b.movie_id = a.id', 'left')
                        ->get('tbl_movies a')->result_array();
    }

    // Retrieves the categories for an movie
    public function get_movie_categories($movie_id)
    {
        $results = $this->db->select('category_id')
                            ->get_where('tbl_movie_category', ['movie_id' => $movie_id])
                            ->result_array();

        $ids = [];
        foreach ($results as $row) $ids[] = $row['category_id'];

        return $ids;
    }

    public function get_ratings(){
      return $this->db->get('tbl_ratings')->result_array();
    }

    public function get_category($id){
      return $this->db->get_where('tbl_categories', ['id' => $id])
                      ->row_array();
    }

    // Retrieve the list of categories as an array.
    public function get_categories()
    {
        return $this->db->get('tbl_categories')->result_array();
    }

    // Retrieve a list of categories as an [id = name] array.
    public function get_categories_array()
    {
        // use a defined function to get the rows we need.
        $results = $this->get_categories();
        $categories = [];

        // fill in the blank array using a foreach loop.
        foreach ($results as $row) $categories[$row['id']] = $row['name'];
        return $categories;
    }

    // Replaces the categories for an movie.
    public function replace_categories($id, $categories = [])
    {
        $this->db->trans_start();

            $this->db->delete('tbl_movie_category', ['movie_id' => $id]);

            // Multiple categories can be chosen, we'll need to loop.
            if (count($categories) > 0)
            {
                $inserts = [];
                foreach ($categories as $cat)
                {
                    $inserts[] = [
                        'movie_id'    => $id,
                        'category_id'   => $cat
                    ];
                }
                $this->db->insert_batch('tbl_movie_category', $inserts);
            }

        $this->db->trans_complete();

        // If the query was not successful, we won't register
        // anything on the database.
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    // Updates the movie information in the database.
    public function update_movie($id, $title, $release_date, $rating, $actors, $writers, $directors)
    {
        // Since the title has changed, the slug will too.
        $slug = url_title($title, 'dash', TRUE);

        $this->db->where('id', $id)
                ->update('tbl_movies', [
                    'title' => $title,
                    'slug'  => $slug,
                    'release_date' => $release_date,
                    'rating'  => $rating,
                    'actors' => $actors,
                    'writers'  => $writers,
                    'directors' => $directors
                ]);

        // to check that this query worked, we'll check the affected rows.
        return $this->db->affected_rows() == 1;
    }
}
