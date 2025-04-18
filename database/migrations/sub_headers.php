<?php

"DROP TABLE IF EXISTS `sub_headers`;";
"CREATE TABLE sub_headers (
    id int NOT NULL AUTO_INCREMENT,
    sub_header_name VARCHAR(100),
    header_id int,
    
    PRIMARY KEY (id),
    CONSTRAINT fk_header_id_sub_headers FOREIGN KEY (header_id) REFERENCES headers(id)
    
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 DEFAULT COLLATE=utf8_general_ci;";
