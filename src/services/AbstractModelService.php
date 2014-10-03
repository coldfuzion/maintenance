<?php namespace Stevebauman\Maintenance\Services;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\App;
use Mews\Purifier\Facades\Purifier;

abstract class AbstractModelService {
    
    protected $model;
    
    protected $db;
    
    protected $notFoundException;
    
    public function __construct(){
        $this->db = App::make('db');
    }
    
    /**
     * Return all model records
     *
     * @author Steve Bauman
     *
     * @return object
     */
    public function get($select = array('*')){
            return $this->model->select($select)->get();
    }
	
    /**
     * Apply distinct filtering to the model
     *
     * @author Steve Bauman
     *
     * @return object
     */
    public function distinct(){
            return $this->model->distinct();
    }
	
    /**
     * Apply `with` relations to the model
     *
     * @author Steve Bauman
     *
     * @return object
     */
    public function with($with = array()){
            return $this->model->with($with);
    }
        
    /**
     * Apply `where` filtering to the model
     *
     * If no value is specified, then the operator arguement is used as the value
     * 
     * @author Steve Bauman
     *
     * @return object
     */
    public function where($column, $operator, $value = NULL){
        if(is_null($value)){
            return $this->model->where($column, $operator);
        } else{
            return $this->model->where($column, $operator, $value);
        }

    }
	
    /**
     * Apply order by sorting to the model
     *
     * @author Steve Bauman
     *
     * @return object
     */
    public function orderBy($column, $direction = NULL){
            return $this->model->orderBy($column, $direction);
    }
    
    public function groupBy($column){
        return $this->model->groupBy($column);
    }
	
    /**
     * Find a record by ID
     *
     * @author Steve Bauman
     *
	 * @param $id (int/string)
     * @return object
     */
    public function find($id){
            if($record = $this->model->find($id)){
                    return $record;
            } else{
                    throw new $this->notFoundException;
            }
    }
	
    /**
     * Destroy a record from given ID
     *
     * @author Steve Bauman
     *
	 * @param $id (int/string)
     * @return boolean
     */
    public function destroy($id){
            if($this->model->destroy($id)){
                    return true;
            } return false;
    }
    
    /**
     * Cleans input from data removing invalid HTML tags such as scripts
     * 
     * @param type $input
     * @return type
     */
    protected function clean($input){
        if($input){
            $cleaned = Purifier::clean($input);
            
            return $cleaned;
        } else{
            return NULL;
        }
    }
    
    /**
     * Returns input from the client. If clean is set to true, the input will be
     * ran through the purifier before it is returned.
     * 
     * @param type $input
     * @param type $clean
     * @return null OR Input
     */
    protected function input($input, $clean = FALSE){
        if(Input::has($input)){
            if($clean){
                return $this->clean(Input::get($input));
            } else{
                return Input::get($input);
            }
        }
        
        return NULL;
    }
    
    protected function inputAll(){
        return Input::all();
    }
    
    /**
     * Formats javascript plugin 'Pickadate' and 'Pickatime' date strings into PHP dates
     * 
     * @param type $date
     * @param type $time
     * @return null OR date
     */
    protected function formatDateWithTime($date, $time = NULL){
        if($date){
                return date('Y-m-d H:i:s', strtotime($date. ' ' .$time));
        } return NULL;
    }

	
}