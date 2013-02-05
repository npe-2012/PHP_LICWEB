<?php

namespace Model;

interface FinderInterface
{
    /**
     * Returns all elements.
     *
     * @return array
     */
    public function findAll();

    /**
     * Retrieve an element by its id.
     *
     * @param  mixed      $id
     * @return null|mixed
     */
    public function findOneById($id);
    
    /**
     * Add a new location
     * @param mixed $name
     * @return mixed
     */
    public function create($name);
    
    
    /**
     * update a location
     * @param mixed $id
     * @param mixed $name
     */
    public function update($id, $name);
    
    
    /**
     * delete a location
     * @param mixed $id
     */
    public function delete($id);
}
