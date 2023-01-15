<?php
class SysSession extends Modele implements SessionHandlerInterface
{
    public function open(string $savePath, string $sessionName): bool
    {
        //open with Modele
        return true;
    }
    public function close(): bool
    {
        //Closed by Modele
        return true;
    }
    public function read($id): bool|string
    {
        $sql = "SELECT data FROM Session WHERE  id = :id AND expires > :date";
        $res = self::executeRequest($sql, [":id" => $id, ":date" => date('Y-m-d H:i:s')])->fetch();
        if (!$res) {
            $this->write(session_id(), "");
        }
        return $res ? $res[0] : "";
    }
    public function write($id, $data): bool
    {
        $DateTime = date('Y-m-d H:i:s');
        $NewDateTime = date('Y-m-d H:i:s', strtotime($DateTime . ' + 5 minutes'));
        $sql = "INSERT INTO Session Values(:id,:date,:data) ON DUPLICATE KEY UPDATE  expires = :date,  data = :data ";
        self::executeRequest($sql, [":id" => $id, ":date" => $NewDateTime, ":data" => $data]);
        return true;
    }
    public function destroy($id): bool
    {
        //delete session and order , order items and order status by cascade
        $sql = "DELETE FROM Session where  id = ?";
        self::executeRequest($sql, [$id])->fetch();
        return true;
    }

    public function gc($maxlifetime): bool
    {
        //delete session and order , order items and order status by cascade
        $sql = "DELETE FROM Session WHERE data <:date";
        self::executeRequest($sql, [":date" => date('Y-m-d H:i:s')])->fetch();
        return false;
    }
}
