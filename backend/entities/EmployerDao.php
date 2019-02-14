<?php
include_once __DIR__ . '\..\includes.php';

class EmployerDao extends EntityDao
{
    /**
     * @param Employer $entity
     * @return Employer[]|bool
     */
    function select($entity)
    {
        $ids = (new DaoQuery(DaoQuery::SELECT))
            ->tables('employer_cgt_fields')
            ->columns('employer_id AS \'\'')
            ->where(['cgt_field_id' => $entity->cgt_field_ids]);

        $ids = $this->conn->execute($ids, true);

        $q = (new DaoQuery(DaoQuery::SELECT))
            ->tables('employer E', 'employer_cgt_fields F')
            ->columns('E.*, GROUP_CONCAT(F.cgt_field_id) as cgt_field_ids')
            ->where('E.id = F.employer_id')
            ->where([
                'E.id' => $ids,
                'E.name' => $entity->name,
                'E.address' => $entity->address
            ])
            ->group_by('E.id');

        $results = $this->conn->execute($q);

        foreach ($results as &$result) {
            $result['cgt_field_ids'] = explode(',', $result['cgt_field_ids']);
            $result = new Employer($result);
        }

        return $results;
    }

    /**
     * @param Employer $entity
     * @return bool
     */
    public function insert(&$entity)
    {
        $entity->search_str = self::get_search_str($entity->name);

        $q = (new DaoQuery(DaoQuery::INSERT))
            ->tables('employer')
            ->columns('name', 'address', 'search_str')
            ->values($entity);

        if ($this->conn->execute($q)) {
            $entity->id = $this->conn->insert_id();

            $q = (new DaoQuery(DaoQuery::INSERT_IGNORE))
                ->tables('employer_cgt_fields')
                ->columns('employer_id', 'cgt_field_id');

            foreach ($entity->cgt_field_ids as $id) {
                $q->values(['employer_id' => $entity->id, 'cgt_field_id' => $id]);
            }

            return $this->conn->execute($q) && $this->conn->affected_rows() > 0;
        } else {
            return false;
        }
    }

    /**
     * @param Employer $entity
     * @return bool
     */
    public function delete($entity)
    {
        return parent::delete($entity);
    }

    /**
     * @param string $name
     * @return Employer|bool
     */
    public function find_by_name($name)
    {
        $search_str = self::get_search_str($name);
        $search_str = '%' . $search_str . '%';

        $query = (new DaoQuery(DaoQuery::SELECT))
            ->tables('employer')
            ->where(['search_str LIKE' => $search_str]);

        if ($result = DaoConnection::default_conn()->execute($query)) {
            $result = $result[0];
            return new Employer($result);
        } else {
            return false;
        }
    }

    public function update_cgt_fields($employer_id, $cgt_field_ids)
    {
        $query = (new DaoQuery(DaoQuery::INSERT_IGNORE))
            ->tables('employer_cgt_fields');

        foreach ($cgt_field_ids as $field_id) {
            $query->values(['employer_id' => $employer_id, 'cgt_field_id' => $field_id]);
        }

        return $this->conn->execute($query);
    }

    /**
     * @param string $name
     * @return string
     */
    public static function get_search_str($name)
    {
        return preg_replace('/[^a-z]/', '', strtolower($name));
    }
}