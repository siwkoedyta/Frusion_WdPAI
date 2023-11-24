<?php

class CreateTransaction {
    private $userID;
    private $boxID;
    private $weight;
    private $number_of_boxes;
    private $priceID;

    public function __construct($client_id, $box_id, $weight, $number_of_boxes, $price_id) {
        $this->client_id = $client_id;
        $this->box_id = $box_id;
        $this->weight = $weight;
        $this->number_of_boxes = $number_of_boxes;
        $this->price_id = $price_id;
    }

    public function create() {
        $transaction = new Transaction(
            null,  // Zakładając, że jest to pole automatycznie zwiększane w bazie danych
            $this->client_id,
            $this->box_id,
            $this->weight,
            $this->number_of_boxes,
            date("d-m-Y"),  // Obecna data
            $this->price_id
        );

        // Zakładając, że masz metodę zapisania transakcji w bazie danych
        $transaction_id = $this->saveTransactionToDatabase($transaction);

        return $transaction_id;
    }

}
