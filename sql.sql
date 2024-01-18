-- auto-generated definition

create table public."Admin" (
                                "idAdmin" integer primary key not null default nextval('"Admin_idAdmin_seq"'::regclass),
                                email character varying(255) not null,
                                password character varying(255) not null,
                                phone character varying(255) not null,
                                "frusionName" character varying(255) not null
);

create table "Box"
(
                                "idBox"     serial
                                    constraint "idBox"
                                        primary key,
                                "typeBox"   varchar(255)     not null,
                                "weightBox" double precision not null,
                                "idAdmin"   integer
);

create table public."Comment" (
                                  "idComment" integer primary key not null default nextval('"Comment_idComment_seq"'::regclass),
                                  "idPrice" integer not null,
                                  comment character varying(500) not null,
                                  foreign key ("idPrice") references public."FruitPrices" ("idPrice")
                                      match simple on update no action on delete no action
);

create table "Fruit"
(
                                "idFruit"   serial
                                    constraint "idFruit"
                                        primary key,
                                "typeFruit" varchar(255) not null,
                                "idAdmin"   integer
);

create table public."FruitPrices" (
                                      "idPrice" integer primary key not null default nextval('"FruitPrices_idPrice_seq"'::regclass),
                                      "idFruit" integer not null,
                                      price double precision not null,
                                      "datePrice" date not null,
                                      foreign key ("idFruit") references public."Fruit" ("idFruit")
                                          match simple on update no action on delete no action
);

create table "Transaction"
(
    "idTransaction"   serial
        constraint "idTransaction"
            primary key,
    "idUser"          integer not null
        constraint "idUser"
            references "User"
            on update cascade on delete cascade,
    "idAdmin"         integer not null
        constraint "idAdmin"
            references "Admin"
            on update cascade on delete cascade,
    weight_with_boxes numeric not null,
    "idBox"           integer not null
        constraint "idBox"
            references "Box"
            on update cascade on delete cascade,
    "numberOfBoxes"   integer not null,
    "idPrice"         integer not null
        constraint "idPrice"
            references "FruitPrices"
            on update cascade on delete cascade,
    "transactionDate" date    not null,
    weight            numeric not null,
    amount            numeric not null,
    "priceFruit"      numeric
);



create table "User"
(
    "idUser"    serial
        constraint "idUser"
            primary key,
    "firstName" varchar(255) not null,
    "lastName"  varchar(255) not null,
    email       varchar(255) not null,
    password    varchar(255) not null,
    "idAdmin"   integer
);


