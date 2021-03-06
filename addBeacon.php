<?php

function addBeacon($data, $repository) {
    
    $gnds = array();
    foreach ($data as $item) {
        foreach ($item->persons as $person) {
            if ($person->gnd) {
                $gnds[] = $person->gnd;
            }
        }
    }
    $gnds = array_unique($gnds);
    $matches = $repository->getMatchesMulti($gnds);
    foreach ($data as $item) {
        foreach ($item->persons as $person) {
            if ($person->gnd) {
                if (!empty($matches[$person->gnd])) {
                    $person->beacon = $matches[$person->gnd];
                }
            }
        }
    }
    return($data);
}

?>
