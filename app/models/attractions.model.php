<?php
require_once 'db.model.php';

class AttractionModel extends Model {
	
	function getAttractions() {
        $query = $this->db->prepare("SELECT attractions.*, countries.name AS countries FROM attractions INNER JOIN countries ON attractions.country_id = countries.id");
        $query->execute();  
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function getAttractionById($id) {
        $query = $this->db->prepare("SELECT attractions.*, countries.name AS country, countries.id AS idCountry, countries.currency AS currency FROM attractions INNER JOIN countries ON attractions.country_id = countries.id WHERE attractions.id = ?");
        $query->execute([$id]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
    
    function getAttractionByCountry($country) {
        $query = $this->db->prepare("SELECT attractions.*, countries.name AS pais FROM attractions INNER JOIN countries ON attractions.country_id = countries.id WHERE countries.name = ?");
        $query->execute([$country]);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function addAttraction($name, $location, $price, $path_img = null, $description, $open_time, $close_time, $website, $country_id) {
        $pathImg = null;
		if ($path_img)
            $pathImg = $this->uploadImage($path_img);
		else
			$pathImg = "images/imagen-no-disponible.png";
		$query = $this->db->prepare("INSERT INTO attractions (name, location, price, path_img, description, open_time, close_time, website, country_id) VALUES(?,?,?,?,?,?,?,?,?)");
        $query->execute([$name, $location, $price, $pathImg, $description, $open_time, $close_time, $website, $country_id]);
        return $this->db->lastInsertId();
    }

    function deleteAttraction($id) {
        $query = $this->db->prepare("DELETE FROM attractions WHERE id = ?");
        $query->execute([$id]);
		return $query->rowCount();
    }

    function updateAttraction($name, $location, $price, $description, $open_time, $close_time, $website, $country_id, $id, $path_img= null) {
		$pathImg = null;
		if ($path_img){
            //$pathImg = $this->uploadImage($path_img);
			$query = $this->db->prepare("UPDATE attractions SET name = ?, location = ?, price = ? , path_img = ?, description = ?, open_time = ?, close_time = ?, website = ?, country_id = ? WHERE id = ?");
			$query->execute([$name, $location, $price, $pathImg, $description, $open_time, $close_time, $website, $country_id, $id]);
		}else{
			$query = $this->db->prepare("UPDATE attractions SET name = ?, location = ?, price = ? , description = ?, open_time = ?, close_time = ?, website = ?, country_id = ? WHERE id = ?");
			$query->execute([$name, $location, $price, $description, $open_time, $close_time, $website, $country_id, $id]);
		}
		return $query->rowCount();
    }
	
	/*private function uploadImage ($image){
		$newFilePath = "images/" . uniqid() . "." . strtolower(pathinfo($image['name'], PATHINFO_EXTENSION)); 
        move_uploaded_file($image['tmp_name'], $newFilePath);
        return $newFilePath;
    }*/
	
	public function getAttractionByName($name) {
        $query = $this->db->prepare("SELECT * FROM attractions WHERE name = ?");
        $query->execute([$name]);
        return $query->fetch(PDO::FETCH_OBJ);
    }
}