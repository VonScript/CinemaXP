<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Movie_model extends CI_Model
{
    // Creates an movie and assigns its categories.
    public function create_movie($title, $release_date, $rating, $actors, $writers, $directors, $price, $categories)
    {
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

    // Deletes an movie from the database.
    public function delete_movie($slug)
    {
        $this->db->delete('tbl_movies', ['slug' => $slug]);
    }

    // Retrieves a single movie from the database.
    public function get_movie($slug)
    {
        return $this->db
                    ->get_where('tbl_movies', ['slug' => $slug])
                    ->row_array();
    }

    // Retrieves movies from the database.
    public function get_movies()
    {
        return $this->db->order_by('title')->get('tbl_movies')->result_array();
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
      return $this->db->select('rating')->get('tbl_ratings')->result_array();
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
    public function update_movie($id, $title, $release_date, $rating, $actors, $writers, $directors, $price, $categories)
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
                    'directors' => $directors,
                    'price' => $price
                ]);

        // to check that this query worked, we'll check the affected rows.
        return $this->db->affected_rows() == 1;
    }
}
