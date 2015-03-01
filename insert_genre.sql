-- PARENTS
insert into genre (id, name, parent_id) values (1, 'Adult', null);
insert into genre (id, name, parent_id) values (2, 'YA', null);
insert into genre (id, name, parent_id) values (3, 'Children', null);

insert into genre (id, name, parent_id) values (4, 'Non-fictie', 1);
insert into genre (id, name, parent_id) values (5, 'Fictie', 1);

-- NON-FICTIE
insert into genre (id, name, parent_id) values (6, 'Geschiedenis en politiek', 4);
insert into genre (id, name, parent_id) values (7, 'Sociale wetenschappen', 4);
insert into genre (id, name, parent_id) values (8, 'Biografie', 4);
insert into genre (id, name, parent_id) values (9, 'Gedichtenbundel', 4);
insert into genre (id, name, parent_id) values (10, 'Grammatica', 4);
insert into genre (id, name, parent_id) values (11, 'Filosofie', 4);

-- FICTIE
insert into genre (id, name, parent_id) values (12, 'Roman', 5);
insert into genre (id, name, parent_id) values (13, 'Verhalenbundel', 5);
insert into genre (id, name, parent_id) values (14, 'Fantasy', 5);
insert into genre (id, name, parent_id) values (15, 'Thriller/detective', 5);
insert into genre (id, name, parent_id) values (16, 'Graphic novel', 5);
insert into genre (id, name, parent_id) values (17, 'Historische roman', 5);
insert into genre (id, name, parent_id) values (18, 'Humor', 5);