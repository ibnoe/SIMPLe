<?php
class Msatker extends CI_Model
{
    /**
     * @param $cs Nomer CS (A, B, C, D atau E)
     * @return Integer
     */
    public function antrian_terakhir($cs)
    {
        $sql = "SELECT MAX(number) number FROM `antrian` WHERE cs='{$cs}'";
        $result = $this->db->query($sql);
        $temp = $result->result();
        $temp = $temp[0];
        return $temp->number;
    }

    /**
     * Naikin angka antrian
     *
     * @param $cs Nomer CS (A, B, C, D atau E)
     * @return void
     */
    public function plusone($cs)
    {
        $cs = strtoupper($cs);
        $antrian_terakhir = $this->antrian_terakhir($cs) + 1;
        $this->db->query("INSERT INTO `antrian` (number, cs) VALUES ('{$antrian_terakhir}', '{$cs}')");
    }
}