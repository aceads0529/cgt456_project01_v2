<?php
include_once __DIR__ . '\..\environment.php';

class EmployerDao2
{
    private $conn;

    public function __construct()
    {
        $this->conn = env_default_conn();
    }

    /**
     * @param int $id
     * @return Employer
     * @throws Exception
     */
    public function select($id)
    {
        $stmt = $this->conn->execute(
            'SELECT E.*, GROUP_CONCAT(F.cgt_field_id) FROM employer E, employer_cgt_fields F WHERE E.id = F.employer_id AND E.id = :id GROUP BY E.id',
            ['id' => $id]);

        /** @var Employer $employer */
        $employer = null;

        if ($stmt) {
            $employer = $stmt->fetch(PDO::FETCH_CLASS, 'Employer');
            $employer->cgt_field_ids = explode(',', $employer->cgt_field_ids);
        }

        return $employer;
    }

    /**
     * @param Employer $employer
     * @throws Exception
     */
    public function insert($employer)
    {
        $stmt = $this->conn->execute(
            'INSERT INTO employer (name, address, search_str) VALUES (:name, :address, :search_str)',
            ['name' => $employer->name, 'address' => $employer->address, 'search_str' => $employer->get_search_str()]);

        if ($stmt->rowCount() > 0) {
            foreach ($employer->cgt_field_ids as $field) {
                $this->conn->execute(
                    'INSERT IGNORE INTO employer_cgt_fields VALUES (:employer, :field)',
                    ['employer' => $employer->id, 'field' => $field]);
            }
        }
    }
}
