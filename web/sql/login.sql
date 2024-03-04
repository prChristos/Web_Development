CREATE TABLE `aithmata` (
 `username` varchar(30) DEFAULT NULL FOREIGN KEY REFERENCES users(username),
 `onoma` varchar(30) NOT NULL FOREIGN KEY REFERENCES users(onoma),
 `mobile` varchar(30) NOT NULL,
 `eidos` varchar(30) DEFAULT NULL FOREIGN KEY REFERENCES categories(cat_name),
 `proion` varchar(30) NOT NULL FOREIGN KEY REFERENCES products(pr_name),
 `atoma` int(50) DEFAULT NULL,
 `egine_dekto` varchar(3) DEFAULT NULL,
 `hmerominia_aitisis` date DEFAULT NULL,
 `hmerominia_oloklirosis` date DEFAULT NULL,
 `latitude` varchar(30) NOT NULL FOREIGN KEY REFERENCES users(latitude),
 `longitude` varchar(30) NOT NULL FOREIGN KEY REFERENCES users(longitude),

);


CREATE TABLE `aithmatapolith` (
 `username` varchar(30) DEFAULT NULL,
 `eidos` varchar(30) DEFAULT NULL,
 `proion` varchar(30) NOT NULL,
 `atoma` int(50) DEFAULT NULL,
FOREIGN KEY (username) REFERENCES users(username),
FOREIGN KEY (eidos) REFERENCES categories(cat_name),
FOREIGN KEY (proion) REFERENCES products(pr_name)
);

CREATE TABLE `anakoinoseis` (
 `id_anak` int(5) NOT NULL AUTO_INCREMENT,
 `keimeno` text DEFAULT NULL,
 `hmerominia_dimosieusis` date NOT NULL,
 PRIMARY KEY (`id_anak`)
);

CREATE TABLE `categories` (
 `cat_id` int(11) NOT NULL,
 `cat_name` varchar(30) NOT NULL,
 PRIMARY KEY (`cat_id`)
);

CREATE TABLE `diasostes` (
 `username` varchar(30) NOT NULL,
 `car_id` varchar(30) NOT NULL,
FOREIGN KEY (username) REFERENCES users(username),
FOREIGN KEY (car_id) REFERENCES oxhmata(cid)
);

CREATE TABLE `dorees` (
 `donId` int(10) NOT NULL AUTO_INCREMENT,
 `username` varchar(30) DEFAULT NULL,
 `onoma` varchar(30) DEFAULT NULL,
 `mobile` varchar(30) DEFAULT NULL,
 `proion` varchar(30) DEFAULT NULL,
 `atoma` int(50) DEFAULT NULL,
 `egine_dekto` varchar(3) DEFAULT NULL,
 `hmerominia_doreas` date DEFAULT NULL,
 `hmerominia_oloklirosis` date DEFAULT NULL,
 `latitude` varchar(10) NOT NULL,
 `longitude` varchar(10) NOT NULL,
 PRIMARY KEY (`donId`),
FOREIGN KEY (username) REFERENCES users(username),
FOREIGN KEY (proion) REFERENCES products(pr_name),
FOREIGN KEY (onoma) REFERENCES users(onoma),
FOREIGN KEY (latitude) REFERENCES users(latitude),
FOREIGN KEY (longitude) REFERENCES users(longitude)
);

CREATE TABLE `doreespolith` (
 `donId` int(10) NOT NULL AUTO_INCREMENT,
 `username` varchar(30) DEFAULT NULL,
 `proion` varchar(30) DEFAULT NULL,
 `atoma` int(50) DEFAULT NULL,
 PRIMARY KEY (`donId`)
);

CREATE TABLE `loads` (
 `load_id` int(11) NOT NULL AUTO_INCREMENT,
 `car_id` int(11) DEFAULT NULL,
 `pr_name` varchar(255) DEFAULT NULL,
 `category` varchar(50) DEFAULT NULL,
 `quantity` int(11) DEFAULT NULL,
 PRIMARY KEY (`load_id`),
FOREIGN KEY (car_id) REFERENCES oxhmata(cid),
FOREIGN KEY (pr_name) REFERENCES products(pr_name),
FOREIGN KEY (category) REFERENCES categories(cat_name)
);

CREATE TABLE `logintable` (
 `username` varchar(30) DEFAULT NULL,
 `password` varchar(30) DEFAULT NULL,
FOREIGN KEY (password) REFERENCES users(password),
FOREIGN KEY (username) REFERENCES users(username)
);

CREATE TABLE `oxhmata` (
 `username` int(11) NOT NULL,
 `cid` int(11) NOT NULL,
 `latitude` varchar(30) NOT NULL,
 `longitude` varchar(30) NOT NULL,
 PRIMARY KEY (`username`)
);

CREATE TABLE `products` (
 `id` int(11) NOT NULL,
 `pr_name` varchar(50) NOT NULL,
 `category` varchar(50) NOT NULL,
 `quantity` int(10) NOT NULL,
 PRIMARY KEY (`id`)
);

CREATE TABLE `product_details` (
 `pr_id` int(11) NOT NULL,
 `detail_name` varchar(30) NOT NULL,
 `detail_value` varchar(30) NOT NULL,
 `quantity` int(10) NOT NULL,
FOREIGN KEY (pr_id) REFERENCES products(id)

);

CREATE TABLE `tasks` (
 `id_task` int(10) NOT NULL AUTO_INCREMENT,
 `eidos_task` varchar(10) NOT NULL,
 `username_res` varchar(30) NOT NULL,
 `car_id` varchar(30) NOT NULL,
 `citizen_name` varchar(30) NOT NULL,
 `citizen_mobile` varchar(30) NOT NULL,
 `proion` varchar(30) NOT NULL,
 `atoma` varchar(30) NOT NULL,
 `destination_lat` varchar(30) NOT NULL,
 `destination_lng` varchar(30) NOT NULL,
 `task_status` varchar(10) NOT NULL,
 `hmerominia_analipsis` date NOT NULL,
 PRIMARY KEY (`id_task`),
FOREIGN KEY (username_res) REFERENCES users(username),
FOREIGN KEY (car_id) REFERENCES oxhmata(cid),
FOREIGN KEY (citizen_name) REFERENCES users(name),
FOREIGN KEY (citizen_mobile) REFERENCES users(mobile),
FOREIGN KEY (proion) REFERENCES products(pr_name),
FOREIGN KEY (destination_lat) REFERENCES users(latitude),
FOREIGN KEY (destination_lng) REFERENCES users(longitude)
);

CREATE TABLE `users` (
 `id` varchar(30) NOT NULL,
 `username` varchar(30) DEFAULT NULL,
 `password` varchar(30) DEFAULT NULL,
 `name` varchar(30) DEFAULT NULL,
 `mobile` varchar(30) DEFAULT NULL,
 `latitude` varchar(30) DEFAULT NULL,
 `longitude` varchar(30) DEFAULT NULL
);

DELIMITER //

CREATE PROCEDURE InsertTask(
    IN eidos_task varchar,
    IN username_res varchar,
    IN carID varchar,
    IN citizen_name varchar,
    IN citizen_mobile varchar,
    IN proion varchar,
    IN atoma varchar,
    IN destination_lng varchar,
    IN destination_lat varchar,
    IN task_status varchar,
    IN hmerominia_analipsis DATE,
)
BEGIN
    DECLARE taskCount INT;
    
    SELECT COUNT(*) AS taskCount
    FROM tasks
    WHERE car_id = carID;
    
    IF taskCount >= 4 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Car cannot take more than 4 tasks';
    ELSE
        INSERT INTO tasks (eidos_task, username_res, car_id, citizen_name, citizen_mobile, proion, atoma, destination_lat, destination_lat, task_status, hmerominia_analipsis)
        VALUES('eidos_task', 'username_res', 'carID', 'citizen_name', 'citizen_mobile', 'proion', 'atoma', 'destination_lat', 'destination_lat', 'task_status', 'hmerominia_analipsis') 
    END IF;
END//

DELIMITER ;