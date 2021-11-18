<?php

namespace model;

use http\Exception\RuntimeException;
use PDO;

class Bingo {
    private $cards;

    /**
     * Retrieves all Bingo items related to a specific game
     * Each item returned contains:
     *  - Its id for further identification
     *  - Its title (what will be shown in the Bingo sheet)
     *  - Its description
     *  - Its author's name
     *  - The average rating (difficulty) of the challenge
     * @param PDO $db       - The instance of the database
     * @param String $game  - The name of the game to use
     * @return array        - The list of items
     */
    private function getItemsFor(PDO $db, String $game): array {
        error_log(json_encode($db->query('DESC Items')->fetchAll()));

        $preparedStmt = $db->prepare(
                      'SELECT I.item_id, I.title, I.description, A.name, AVG(R.rating) AS difficulty
                             FROM Users A, Items I
                             LEFT OUTER JOIN Ratings R ON I.item_id = R.item
                             WHERE I.author = A.user_id
                               AND I.game = :game
                             GROUP BY I.item_id');

        $preparedStmt->execute(['game' => $game]);

        return $preparedStmt->fetchAll();
    }

    /**
     * Create a new Bingo (25 items) for a specific game.
     * @throws \RuntimeException If the game has less than 25 items.
     * @param PDO $db       - The instance of the database
     * @param String $game  - The name of the game to use
     */
    public function __construct(PDO $db, String $game) {
        $items = $this->getItemsFor($db, $game);
        if (sizeof($items) < 25) {
            throw new RuntimeException("Cannot create Bingo for $game, it has less than 25 items.");
        }

        shuffle($items);

        $this->cards = array_slice($items, 0, 25);
    }

    /**
     * Get the list of items selected for the Bingo.
     * @return array
     */
    public function getItems(): array {
        return $this->cards;
    }
}
