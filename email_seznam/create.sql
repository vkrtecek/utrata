create database if not exists emails;

drop table if exists emails.mail_box;
create table emails.mail_box(
	ID			int(15)			not null auto_increment primary key ,
	eFrom		varchar(255)	CHARACTER SET utf8 COLLATE utf8_czech_ci not null ,
	eTo			varchar(255)	CHARACTER SET utf8 COLLATE utf8_czech_ci not null ,
	eSubject	varchar(255)	CHARACTER SET utf8 COLLATE utf8_czech_ci ,
	eText		longtext		CHARACTER SET utf8 COLLATE utf8_czech_ci ,
	eDate		datetime		not null ,
	eReat		int(1)			not null default 0 ,
	eDel		int(1)			not null default 0 ,
	eSpam		int(1)			not null default 0 ,
	eRecValid	int(1)			not null default 1 ,
	eSendValid	int(1)			not null default 1 
);


drop table if exists emails.mail_users;
create table emails.mail_users(
	ID			int(15)			not null auto_increment primary key ,
	name		varchar(100)	CHARACTER SET utf8 COLLATE utf8_czech_ci not null ,
	sname		varchar(150)	CHARACTER SET utf8 COLLATE utf8_czech_ci not null ,
	controlQue	int(2)			not null ,
	controlAns	varchar(150)	CHARACTER SET utf8 COLLATE utf8_czech_ci not null ,
	user		varchar(255)	CHARACTER SET utf8 COLLATE utf8_czech_ci not null ,
	passwd		varchar(255)	CHARACTER SET utf8 COLLATE utf8_czech_ci not null ,
	domain		varchar(255)	CHARACTER SET utf8 COLLATE utf8_czech_ci not null ,
	nick		varchar(255)	CHARACTER SET utf8 COLLATE utf8_czech_ci not null ,
	eLastDate	datetime		not null ,
	styleColor	varchar(100)	CHARACTER SET utf8 COLLATE utf8_czech_ci not null default 'pink'
);


drop table if exists emails.mail_quests;
create table emails.mail_quests(
	id			int(10)			not null auto_increment primary key ,
	question	varchar(255)	CHARACTER SET utf8 COLLATE utf8_czech_ci not null 
);


drop table if exists emails.mail_domains;
create table emails.mail_domains(
	domain		varchar(255)	CHARACTER SET utf8 COLLATE utf8_czech_ci not null primary key ,
	inUse		int(1) 			not null default 1
);



insert into emails.mail_box ( eFrom, eTo, eSubject, eText, eDate ) values ( 'krtek@krtek.com', 'adam@mymail.cz', 'Hovno', 'Dal by sis?', now() );
insert into emails.mail_box ( eFrom, eTo, eSubject, eText, eDate ) values ( 'adam@mymail.cz', 'krtek@krtek.com', 'RE: Hovno', 'Ne, Ty?', now() );
insert into emails.mail_box ( eFrom, eTo, eSubject, eText, eDate ) values ( 'krtek@krtek.com', 'adam@mymail.cz', 'RE: Hovno', 'Já?', now() );
insert into emails.mail_box ( eFrom, eTo, eSubject, eText, eDate ) values ( 'adam@mymail.cz', 'krtek@krtek.com', 'RE: Hovno', 'Jo, Ty!', now() );
insert into emails.mail_box ( eFrom, eTo, eSubject, eText, eDate ) values ( 'krtek@krtek.com', 'adam@mymail.cz', 'RE: Hovno', 'No, já ne!', now() );
insert into emails.mail_box ( eFrom, eTo, eSubject, eText, eDate ) values ( 'adam@mymail.cz', 'krtek@krtek.com', 'RE: Hovno', 'Tak proč mi to píšeš?', now() );
insert into emails.mail_box ( eFrom, eTo, eSubject, eText, eDate ) values ( 'krtek@krtek.com', 'adam@mymail.cz', 'RE: Hovno', 'Já nevím.', now() );
insert into emails.mail_box ( eFrom, eTo, eSubject, eText, eDate ) values ( 'adam@mymail.cz', 'krtek@krtek.com', 'RE: Hovno', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nullam rhoncus aliquam metus. Et harum quidem rerum facilis est et expedita distinctio. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Fusce tellus. Vestibulum fermentum tortor id mi. Fusce dui leo, imperdiet in, aliquam sit amet, feugiat eu, orci. Nulla pulvinar eleifend sem. Maecenas fermentum, sem in pharetra pellentesque, velit turpis volutpat ante, in pharetra metus odio a lectus. Nullam justo enim, consectetuer nec, ullamcorper ac, vestibulum in, elit. Mauris dictum facilisis augue. Phasellus rhoncus. Fusce aliquam vestibulum ipsum. Mauris elementum mauris vitae tortor. Nunc dapibus tortor vel mi dapibus sollicitudin. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae.\
\
Fusce suscipit libero eget elit. Nunc auctor. Maecenas fermentum, sem in pharetra pellentesque, velit turpis volutpat ante, in pharetra metus odio a lectus. In sem justo, commodo ut, suscipit at, pharetra vitae, orci. Etiam egestas wisi a erat. Sed elit dui, pellentesque a, faucibus vel, interdum nec, diam. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Maecenas fermentum, sem in pharetra pellentesque, velit turpis volutpat ante, in pharetra metus odio a lectus. Phasellus enim erat, vestibulum vel, aliquam a, posuere eu, velit. Etiam sapien elit, consequat eget, tristique non, venenatis quis, ante. Nulla turpis magna, cursus sit amet, suscipit a, interdum id, felis. Etiam egestas wisi a erat. Mauris elementum mauris vitae tortor. Pellentesque arcu. Morbi scelerisque luctus velit. Nullam sit amet magna in magna gravida vehicula. Nullam dapibus fermentum ipsum. Maecenas libero.\
\
Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Duis ante orci, molestie vitae vehicula venenatis, tincidunt ac pede. Sed ac dolor sit amet purus malesuada congue. Vivamus luctus egestas leo. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Duis risus. Morbi leo mi, nonummy eget tristique non, rhoncus non leo. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Praesent in mauris eu tortor porttitor accumsan. In laoreet, magna id viverra tincidunt, sem odio bibendum justo, vel imperdiet sapien wisi sed libero. Maecenas fermentum, sem in pharetra pellentesque, velit turpis volutpat ante, in pharetra metus odio a lectus. Nullam rhoncus aliquam metus. Integer pellentesque quam vel velit. Morbi scelerisque luctus velit. Vestibulum erat nulla, ullamcorper nec, rutrum non, nonummy ac, erat. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus.\
\
Quisque porta. Proin pede metus, vulputate nec, fermentum fringilla, vehicula vitae, justo. Donec ipsum massa, ullamcorper in, auctor et, scelerisque sed, est. In convallis. Integer tempor. Fusce aliquam vestibulum ipsum. Phasellus faucibus molestie nisl. Fusce suscipit libero eget elit. Pellentesque arcu. Nunc dapibus tortor vel mi dapibus sollicitudin. Praesent in mauris eu tortor porttitor accumsan. Aenean vel massa quis mauris vehicula lacinia. Nullam at arcu a est sollicitudin euismod. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Praesent vitae arcu tempor neque lacinia pretium. Integer in sapien. Mauris tincidunt sem sed arcu. Nunc auctor.\
\
Donec iaculis gravida nulla. Et harum quidem rerum facilis est et expedita distinctio. In sem justo, commodo ut, suscipit at, pharetra vitae, orci. Curabitur ligula sapien, pulvinar a vestibulum quis, facilisis vel sapien. Vivamus luctus egestas leo. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Nullam lectus justo, vulputate eget mollis sed, tempor sed magna. Pellentesque ipsum. Vivamus luctus egestas leo. Donec ipsum massa, ullamcorper in, auctor et, scelerisque sed, est. Ut tempus purus at lorem. Phasellus faucibus molestie nisl. Nulla est. Maecenas fermentum, sem in pharetra pellentesque, velit turpis volutpat ante, in pharetra metus odio a lectus.', now() );




insert into emails.mail_users ( name, sname, controlQue, controlAns, user, passwd, domain, nick, eLastDate ) values ( 'Vojtěch', 'Stuchlík', 1, 'a', 'krtek', 'sauron', 'krtek.com', 'Vojtěch Stuchlík', now() );
insert into emails.mail_users ( name, sname, controlQue, controlAns, user, passwd, domain, nick, eLastDate ) values ( 'Adam', 'Eichler', 3, 'a', 'adam', 'klubovna', 'mymail.cz', 'Adam Eichler', now() );



insert into emails.mail_quests ( question ) VALUES ( 'Příjmení matky za svobodna' );
insert into emails.mail_quests ( question ) VALUES ( 'Jméno oblíbeného filmu' );
insert into emails.mail_quests ( question ) VALUES ( 'Jméno první lásky' );
insert into emails.mail_quests ( question ) VALUES ( 'Počet pokojů ve vašem domě' );
insert into emails.mail_quests ( question ) VALUES ( 'Jméno tvého psa' );



insert into emails.mail_domains ( domain, inUse ) values ( 'mymail.cz', 1 );
insert into emails.mail_domains ( domain, inUse ) values ( 'krtek.com', 1 );