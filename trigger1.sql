source veterinary_hospital.sql;

source populating_veterinary_hospital.sql;


/********** APAGAR PARA CIMA **********/

drop trigger if exists update_age;

delimiter $$

create trigger update_age 
after insert on consult
for each row
begin
	declare b_year timestamp;

	select birth_year into b_year
	from animal
	where animal.name = new.name
	and animal.VAT = new.VAT_owner;

	update animal
	set age = TIMESTAMPDIFF(YEAR, b_year, NOW())
	where new.name = animal.name
	and new.VAT_owner = animal.VAT;
end $$

delimiter ;

/********** APAGAR PARA BAIXO **********/

select * from animal;

select name, VAT_owner, date_timestamp from consult;

insert into consult values ('Cooper', 123456033, '2030-11-02 08:00:00' , 'A', 'A', 'A', 'A', 123456033, 123456006, 1.62);

insert into consult values ('Cooper', 123456033, '2015-10-02 08:00:00' , 'A', 'A', 'A', 'A', 123456033, 123456006, 1.62);

select * from animal;

select name, VAT_owner, date_timestamp from consult;