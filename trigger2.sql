drop trigger if exists ensure1;
drop trigger if exists ensure2;
drop trigger if exists ensure3;
drop trigger if exists ensure4;

/********** PRIMEIRO TRIGGER **********/

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
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Warning: an individual that is a veterinary doctor cannot simultaneously be an assistant in the hospital!';
    end if;
end $$

delimiter ;

/********** SEGUNDO TRIGGER **********/

delimiter $$

create trigger ensure2 
before update on veterinary
for each row
begin
	declare a_count integer;

	select count(*) into a_count
	from assistant
	where assistant.VAT = new.VAT;

	if a_count <> 0 then
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Warning: an individual that is a veterinary doctor cannot simultaneously be an assistant in the hospital!';
    end if;
end $$

delimiter ;

/********** TERCEIRO TRIGGER **********/

delimiter $$

create trigger ensure3
before insert on assistant
for each row
begin
	declare a_count integer;

	select count(*) into a_count
	from veterinary
	where veterinary.VAT = new.VAT;

	if a_count <> 0 then
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Warning: an individual that is a veterinary doctor cannot simultaneously be an assistant in the hospital!';
    end if;
end $$

delimiter ;

/********** QUARTO TRIGGER **********/

delimiter $$

create trigger ensure4
before update on assistant
for each row
begin
	declare a_count integer;

	select count(*) into a_count
	from veterinary
	where veterinary.VAT = new.VAT;

	if a_count <> 0 then
    	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Warning: an individual that is a veterinary doctor cannot simultaneously be an assistant in the hospital!';
    end if;
end $$

delimiter ;

/********** CODIGO TESTE **********/

insert into veterinary values (123456007, 'Nutrition', 'Caroline is a 34 year old specialist in Nutrition.');

update veterinary 
set VAT = 123456007, specialization = 'Nutrition', bio = 'Caroline is a 34 year old specialist in Nutrition.'
where VAT = 123456005;

insert into assistant values (123456004);

update assistant 
set VAT = 123456005
where VAT = 123456007;