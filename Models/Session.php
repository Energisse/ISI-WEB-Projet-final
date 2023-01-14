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
        $sql = "SELECT Session_Data FROM Session WHERE Session_Id = :id AND Session_Expires > :date";
        $res = self::executeRequest($sql, [":id" => $id, ":date" => date('Y-m-d H:i:s')])->fetch();
        return $res ? $res[0] : "";
    }
    public function write($id, $data): bool
    {
        $DateTime = date('Y-m-d H:i:s');
        $NewDateTime = date('Y-m-d H:i:s', strtotime($DateTime . ' + 5 minutes'));
        $sql = "REPLACE INTO Session SET Session_Id = :id, Session_Expires = :date, Session_Data = :data,basket_order_id =:basket_order_id ";
        self::executeRequest($sql, [":id" => $id, ":date" => $NewDateTime, ":data" => $data, ':basket_order_id' => $_SESSION["basketOrderId"]]);
        return true;
    }
    public function destroy($id): bool
    {
        //delete session and order , order items and order status by cascade
        $sql = "DELETE FROM Session where Session_Id = ?";
        self::executeRequest($sql, [$id])->fetch();
        return true;
    }

    public function gc($maxlifetime): bool
    {
        //delete session and order , order items and order status by cascade
        $sql = "DELETE FROM Session WHERE Session_Data <:date";
        self::executeRequest($sql, [":date" => date('Y-m-d H:i:s')])->fetch();
        return false;
    }

    private function unserialize_php($session_data)
    {
        $return_data = array();
        $offset = 0;
        while ($offset < strlen($session_data)) {
            if (!strstr(substr($session_data, $offset), "|")) {
                throw new Exception("invalid data, remaining: " . substr($session_data, $offset));
            }
            $pos = strpos($session_data, "|", $offset);
            $num = $pos - $offset;
            $varname = substr($session_data, $offset, $num);
            $offset += $num + 1;
            $data = unserialize(substr($session_data, $offset));
            $return_data[$varname] = $data;
            $offset += strlen(serialize($data));
        }
        return $return_data;
    }
}
