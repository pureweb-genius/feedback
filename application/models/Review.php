<?php

namespace application\models;

use application\core\Model;

class Review extends Model {


	public function getAll() {
		return $this->db->row('SELECT * FROM reviews');
	}


    public function store($data)
    {
               $name = $data['name'];
               $email = $data['email'];
               $text = $data['text'];


        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_path = '/feedback/public/images/' . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
        } else {
            $image_path = null;
        }


        $this->db->query('INSERT INTO reviews (name, email, text, image_path) VALUES (:name, :email, :text, :image_path)', ['name' => $name, 'email' => $email, 'text' => $text, 'image_path' => $image_path]);


        $reviews = $this->db->row('SELECT * FROM reviews');

        $response = array("success" => true, "message" => "Отзыв успешно сохранен.", "reviews" => $reviews);
        echo json_encode($response);


    }

    public function sortBy($sort)
    {
        $reviews = $this->getAll();
        if ($sort=='default')
        {
            return $reviews;
        }
        else if($sort == 'date')
        {
            usort($reviews, function($a, $b) {
                return strtotime($b['created_at']) - strtotime($a['created_at']);
            });
            return $reviews;
        }
        else if($sort == 'name')
        {
            usort($reviews, function($a, $b) {
                return strcmp($a['name'], $b['name']);
            });
            return $reviews;
        }
        else if($sort == 'email')
        {
            usort($reviews, function($a, $b) {
                return strcmp($a['email'], $b['email']);
            });
            return $reviews;
        }
    }

    public function delete($id)
    {
        $this->db->query('DELETE FROM reviews WHERE id = :id', ['id' => $id]);
    }

    public function update($data)
    {
        $id = $data['id'];
        $name = $data['name'];
        $text = $data['text'];

        $this->db->query('UPDATE reviews SET name = :name, text = :text WHERE id = :id', ['id' => $id, 'name' => $name, 'text' => $text]);
    }



}