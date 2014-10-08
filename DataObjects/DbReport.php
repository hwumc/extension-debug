<?php
// check for invalid entry point
if(!defined("HMS")) die("Invalid entry point");

class DbReport extends DataObject
{   
    protected $title;
    protected $accessright;
    protected $query;
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function getAccessRight()
    {
        return $this->accessright;   
    }
    
    public function setAccessRight($accessright)
    {
        $this->accessright = $accessright;   
    }
    
    public function getQuery()
    {
        return $this->query;
    }
    
    public function setQuery($query)
    {
        $this->query = $query;   
    }
    
    public function save()
    {
        global $gDatabase;

        if($this->isNew)
        { // insert
            $statement = $gDatabase->prepare("INSERT INTO dbreport (title, accessright, query) VALUES (:title, :accessright, :query );");
            $statement->bindParam(":title", $this->title);
            $statement->bindParam(":accessright", $this->accessright);
            $statement->bindParam(":query", $this->query);;

            if($statement->execute())
            {
                $this->isNew = false;
                $this->id = $gDatabase->lastInsertId();
            }
            else
            {
                throw new SaveFailedException();
            }
        }
        else
        { // update
            $statement = $gDatabase->prepare("UPDATE dbreport SET title = :title, accessright = :accessright, query = :query WHERE id = :id LIMIT 1;");
            $statement->bindParam(":title", $this->title);
            $statement->bindParam(":accessright", $this->accessright);
            $statement->bindParam(":query", $this->query);

            $statement->bindParam(":id", $this->id);

            if(!$statement->execute())
            {
                throw new SaveFailedException();
            }
        }
    }
}
