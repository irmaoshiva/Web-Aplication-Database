/********** APAGAR PARA CIMA **********/

drop trigger if exists ensure1;
drop trigger if exists ensure2;
drop trigger if exists ensure3;
drop trigger if exists ensure4;

delimiter $$

create trigger ensure1 
before insert on veterinary
for each row
begin
	declare a_count integer;

	select count(*) into a_count
	from assistant
	where assistant.VAT = new.VAT;

	if a_count <> 0 then
    	begin
        	rollback transaction;
        	/*raiserror('The student did not pass the course.', 16, 1)*/
    	endº
    end if;
end $$

delimiter ;


/********** APAGAR PARA BAIXO **********/