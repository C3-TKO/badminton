<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * RoundRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GameRepository extends EntityRepository
{
    public function findByRoundId( $idRound )
    {
        $sql = sprintf( "
        SELECT
            r.date,
            ta.id AS id_team_a,
            tb.id AS id_team_b,
            pata.id AS id_player_a_team_a, pata.name AS name_player_a_team_a,
            pbta.id AS id_player_b_team_a, pbta.name AS name_player_b_team_a,
            patb.id AS id_player_a_team_b, patb.name AS name_player_a_team_b,
            pbtb.id AS id_player_b_team_b, pbtb.name AS name_player_b_team_b,
            g.team_a_score,
            g.team_b_score
        FROM round r
        JOIN game AS g ON g.id_round = r.id
        JOIN team AS ta ON ta.id = g.id_team_a
        JOIN team AS tb ON tb.id = g.id_team_b
        JOIN player AS pata ON pata.id = ta.id_player_a
        JOIN player AS pbta ON pbta.id = ta.id_player_b
        JOIN player AS patb ON patb.id = tb.id_player_a
        JOIN player AS pbtb ON pbtb.id = tb.id_player_b
        WHERE r.id = %u
        ORDER BY r.date DESC;
        ", $idRound );

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
