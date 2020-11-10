


select count(*) over() as record_count,(forms.tb_file.field->>'id_system')::text as id_system,
(forms.tb_file.field->>'id_group')::int as id_group,
forms.tb_file.id, 
encode(forms.tb_file.file, 'base64') as file 
from forms.tb_file where (forms.tb_file.field->>'id_system')::text = 'forms' order by forms.tb_file.id limit 15

