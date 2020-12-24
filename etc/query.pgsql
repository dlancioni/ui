set search_path to S20201;


select * from demo.tb_user


                // Set new password
                $new = $jsonUtil->dqt($new);

                // Final update
                $sql = "update tb_user set field = jsonb_set(field, '{password}', '$new') where id = $userId;";


update demo.tb_user set field = jsonb_set(field, '{password}', '4a9b') where field->>'username' = 'demo'