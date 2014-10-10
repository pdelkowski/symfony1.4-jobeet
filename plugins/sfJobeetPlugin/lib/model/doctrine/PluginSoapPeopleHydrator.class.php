<?php

class Doctrine_Hydrator_MyHydrator extends Doctrine_Hydrator_ArrayHierarchyDriver
{
    public function hydrateResultSet($stmt)
    {
        $results = parent::hydrateResultSet($stmt);
        $array = array();

        $array[] = array('User' => array(
            'id'         => $results['User']['id'],
            'username'   => $results['User']['username'],
            'first_name' => $results['Profile']['first_name'],
            'last_name'  => $results['Profile']['last_name'],
        ));

        return $array();
    }
}