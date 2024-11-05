<?php
require_once './app/models/attractions.model.php';
require_once './app/views/json.view.php';
require_once './app/models/country.model.php';

class AttractionApiController
{
    private $model;
    private $view;
    private $countryModel;

    public function __construct() {
        $this->model = new AttractionModel();
		$this->countryModel = new CountryModel();
        $this->view = new JSONView();
    }
	
	// /api/atraccion/:id (GET)
	public function getByID($req, $res) {
        $id = $req->params->id;
        $attraction = $this->model->getAttractionById($id);
        if(!$attraction)
            return $this->view->response("La atraccion con el id=$id no existe", 404);
        return $this->view->response($attraction);
    }
	
	// /api/atraccion (GET)
	public function getAll($req, $res) {
        $attractions = $this->model->getAttractions();
		if (empty($attractions))
            return $this->view->response("No hay atracciones", 204);	
        return $this->view->response($attractions);
    }
	
	// api/atraccion/:id (DELETE)
    public function delete($req, $res) {
        $id = $req->params->id;
        $attraction = $this->model->getAttractionById($id);
        if (!$attraction)
            return $this->view->response("La atraccion con el id=$id no existe", 404);
        $this->model->deleteAttraction($id);
        $this->view->response("La atraccion con el id=$id se eliminó con éxito");
    }
	
	// api/atraccion/:id (PUT)
    public function update($req, $res) {
        $id = $req->params->id;
        $attraction = $this->model->getAttractionById($id);
        if (!$attraction)
            return $this->view->response("La atraccion con el id=$id no existe", 404);
         // valido los datos
		 $validations = $this->validateAndSanitizeFields(['name', 'location', 'price', 'description', 'open_time', 'close_time', 'website', 'country_id']);
		 
         if ($validations) {
            return $this->view->response('Faltan completar datos', 400);
        }
		$image = $this->validateImage($req->body->path_img);
		$officialWebsite = $this->validateAndFormatWebsite($req->body->website);
        $name = $req->body->name;
		$location = $req->body->location;
		$price = $req->body->price;
		$description = $req->body->description;
		$open_time = $req->body->open_time;
		$close_time = $req->body->close_time;
		$website = $officialWebsite;
		$country_id = $req->body->country_id;
		
		if ($this->isDuplicateName($name, $id))
			return $this->view->response('El nombre ya existe', 400); 
		
		$country = $this->countryModel->getCountryById($country_id);
		if (!$country) {
            return $this->view->response('El id del pais no existe', 400);
        }

        $modify = $this->model->updateAttraction($name, $location, $price, $description, $open_time,$close_time,$website,$country_id,$id,$image);

        // obtengo la tarea modificada y la devuelvo en la respuesta
        if ($modify) {
			 $attraction = $this->model->getAttractionById($id);
			 return $this->view->response($attraction, 200); 
		}
		return $this->view->response('No se pudo modificar la atraccion', 500);		
	}
	
	//**************************************************************************
	
    public function addAttraction(){
        AuthHelper::verify();
        $validations = $this->validateAndSanitizeFields(['name', 'location', 'price', 'description', 'open_time', 'close_time', 'website']);
        if ($validations) {
            $image = $this->validateImage($_FILES['path_img']);
            $officialWebsite = $this->validateAndFormatWebsite($_POST['website']);
			if (!$this->isDuplicateName($_POST['name'], null)){
				$id = $this->attractionModel->addAttraction(
					$_POST['name'],
					$_POST['location'],
					$_POST['price'],
					$image,
					$_POST['description'],
					$_POST['open_time'],
					$_POST['close_time'],
					$officialWebsite,
					$_POST['country_id']);
				if ($id) 
					header('Location: ' . BASE_URL . 'atracciones');
				else
					$this->layoutView->showError('No se pudo agregar la atracción');
			} else
				$this->layoutView->showError('El nombre de la atracción ya existe.');
        } else
            $this->layoutView->showError('No se pudo agregar la atracción, faltan completar datos.');
    }

	//****************************************************************************//

    function validateAndSanitizeFields($fields){
        foreach ($fields as $field) {
            if (!isset($req->body->$field) || empty($req->body->$field))
                return false;
            $req->body->$field = htmlspecialchars($req->body->$field, ENT_QUOTES, 'UTF-8');
        }
        return true;
    }

    private function validateImage($img){
        if (isset($img) && strpos($img, ".jpg") || strpos($img, ".png") || strpos($img, ".jpeg")) {
            return $img;
        }
        return null;
    }

    private function validateAndFormatWebsite($website){
        $website = trim($website);
        if (!str_contains($website, 'http://') && !str_contains($website, 'https://')) {
            $website = 'https://' . $website;
        }
        return $website;
    }

	private function isDuplicateName($name, $attractionId) {
		$existingAttraction = $this->model->getAttractionByName($name);
		if ($existingAttraction) {
			if ($attractionId)
				return $existingAttraction->id != $attractionId;
		    else
				return true;
		}
		return false;
	}
}
