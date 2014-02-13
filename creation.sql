create table if not exists utilisateur(id int(4) NOT NULL auto_increment,
       	     		   	       login varchar(20) NOT NULL,
			 	       password varchar(50) NOT NULL,
			 	       PRIMARY KEY (id),
			 	       UNIQUE (login),
			 	       UNIQUE (password)
			 	       );

create table if not exists activite(nom varchar(20) NOT NULL,
       	     	      	   	    PRIMARY KEY (nom)
		      		    );	    

create table if not exists planning(heure int(2) check ((heure>8) and (heure<20)),
									dateDebut date not null,
       	     	      	   	    PRIMARY KEY (heure,dateDebut)		      		    );

create table if not exists creer(utilisateur int(4),
       	     	    	         activite varchar(20),
								heure int(2),
								dateDeb date,
				 FOREIGN KEY (utilisateur) REFERENCES utilisateur(id),
				 FOREIGN KEY (activite) REFERENCES activite(nom),
				 FOREIGN KEY (heure) REFERENCES planning(heure)
				 
				 );
   	     	    	         
INSERT INTO activite values ("java");
INSERT INTO activite values ("python");
INSERT INTO activite values ("café");
INSERT INTO activite values ("repos");
INSERT INTO activite values ("php");
INSERT INTO activite values ("anglais");
