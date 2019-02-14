USE cgt456_project01;

SELECT E.*, GROUP_CONCAT(EF.cgt_field_id) AS cgt_field_ids
FROM employer_cgt_fields EF,
     employer E
       LEFT JOIN
     (SELECT employer_id AS id FROM employer_cgt_fields WHERE cgt_field_id IN ('anim')) F ON F.id = E.id
WHERE E.id = EF.employer_id
GROUP BY E.id;