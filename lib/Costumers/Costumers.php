<?php
class Costumers
{
    /**
     *
     */
    public function __construct()
    {
    }

    /**
     *
     */
    public function __destruct()
    {
    }

    /**
     * Set friendly columns\' names to order tables\' entries
     */
    public function setOrderingValues()
    {
        $ordering = [
            'created_date' => 'Created Date',
            'created_time' => 'Created Time',
            'gmv' => 'GMV',
        ];

        return $ordering;
    }
}
?>
