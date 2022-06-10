SET time_zone = "+00:00";

CREATE TABLE Users (
    id int(30) NOT NULL AUTO_INCREMENT,
    username varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    salt varchar(255) NOT NULL,
    role varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE Entries (
    id int(30) NOT NULL AUTO_INCREMENT,
    user_id int(30) NOT NULL,
    full_name varchar(255) NOT NULL,
    phone_number varchar(60) NOT NULL,
    car_number varchar(60) NOT NULL,
    car_brand varchar(60) NOT NULL,
    service_type varchar(255) NOT NULL,
    status int(30),
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES Users(id)
);

insert into Users(username, password, salt, role) value("admin1", "00ef112a84802dffdb648e3d185ae2211a94eec5a1e2b4ba835d96aa8a69937c", "b2aadb592ae9b8e47f82", "admin");
