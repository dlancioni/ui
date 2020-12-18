set search_path to S20201;



 select * from tb_user


 delete from home.tb_client

 select
field->>'username' as username,
field->>'password' as password
from s20201.tb_user
where field->>'username' = 'joao'

SELECT * FROM information_schema.tables 
WHERE table_schema = 's20201'