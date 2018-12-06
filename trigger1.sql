source veterinary_hospital.sql;

source populating_veterinary_hospital.sql;


/********** APAGAR PARA CIMA **********/

drop trigger if exists update_age;

delimiter $$

create trigger update_age 
after insert on consult
for each row
begin
	update animal
	set age = TIMESTAMPDIFF(YEAR, birth_year, NOW()), animal.name = animal.name, animal.VAT = animal.VAT, animal.birth_year = animal.birth_year
	where animal.name = new.name 
	and animal.VAT = new.VAT_owner;
end $$

delimiter ; 

/********** APAGAR PARA BAIXO **********/

select * from animal;

select name, VAT_owner, date_timestamp from consult;

/*insert into consult values ('Cooper', 123456011, '2030-11-02 08:00:00' , 'A', 'A', 'A', 'A', 123456011, 123456006, 1.62);
*/
insert into consult values ('Cooper', 123456011, '2015-10-02 08:00:00' , 'A', 'A', 'A', 'A', 123456011, 123456006, 1.62);

select * from animal;

select name, VAT_owner, date_timestamp from consult;

/*

select birth_year
from animal
where animal.name = 'Cooper'
and animal.VAT = 123456011;

select TIMESTAMPDIFF(YEAR, '2006-04-05 00:00:00', CURDATE());
*/