select tb_domain.id,count(*) over() as record_count, (tb_domain.field->>'key')::text as key, (tb_domain.field->>'value')::text as value, (tb_domain.field->>'domain')::text as domain 
from tb_domain where (tb_domain.field->>'id_system')::int = 1 
and (tb_domain.field->>'key')::text = 'A4' 
and (tb_domain.field->>'domain')::text = 'tb_message' 
order by tb_domain.id