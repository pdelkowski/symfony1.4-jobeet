<?php

class Doctrine_Hydrator_SoapPeopleHydrator extends Doctrine_Hydrator_RecordHierarchyDriver
{
    private $properties = array();

    public function hydrateResultSet($stmt)
    {
        $new_data = array();
        $i = 0;
        $fetched_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ( $fetched_data as $item ) {
            foreach ($item as $key => $value) {
                $new_key = explode('__', $key);
                $new_data[$i][$new_key[1]] = $value;
            }
            $i++;
        }
        
        $data = new Doctrine_Collection('JobeetJob');
        $data->setData($new_data);        

        return $data;
    }
}