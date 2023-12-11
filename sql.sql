-- auto-generated definition

create table public."Admin" (
                                "idAdmin" integer primary key not null default nextval('"Admin_idAdmin_seq"'::regclass),
                                email character varying(255) not null,
                                password character varying(255) not null,
                                phone character varying(255) not null,
                                "frusionName" character varying(255) not null
);

create table public."Box" (
                              "idBox" integer primary key not null default nextval('"Box_idBox_seq"'::regclass),
                              "typeBox" character varying(255) not null,
                              "weightBox" double precision not null
);


create table public."Comment" (
                                  "idComment" integer primary key not null default nextval('"Comment_idComment_seq"'::regclass),
                                  "idPrice" integer not null,
                                  comment character varying(500) not null,
                                  foreign key ("idPrice") references public."FruitPrices" ("idPrice")
                                      match simple on update no action on delete no action
);

create table public."Fruit" (
                                "idFruit" integer primary key not null default nextval('"Fruit_idFruit_seq"'::regclass),
                                "typeFruit" character varying(255) not null
);

create table public."FruitPrices" (
                                      "idPrice" integer primary key not null default nextval('"FruitPrices_idPrice_seq"'::regclass),
                                      "idFruit" integer not null,
                                      price double precision not null,
                                      "datePrice" date not null,
                                      foreign key ("idFruit") references public."Fruit" ("idFruit")
                                          match simple on update no action on delete no action
);

create table public."Transaction" (
                                      "idTransaction" integer primary key not null default nextval('"Transaction_idTransaction_seq"'::regclass),
                                      "idUser" integer not null,
                                      "idAdmin" integer not null,
                                      weight_with_boxes numeric not null,
                                      "idBox" integer not null,
                                      "numberOfBoxes" integer not null,
                                      "idPrice" integer not null,
                                      "transactionDate" date not null,
                                      weight numeric not null,
                                      amount numeric not null,
                                      foreign key ("idAdmin") references public."Admin" ("idAdmin")
                                          match simple on update no action on delete no action,
                                      foreign key ("idBox") references public."Box" ("idBox")
                                          match simple on update no action on delete no action,
                                      foreign key ("idPrice") references public."FruitPrices" ("idPrice")
                                          match simple on update no action on delete no action,
                                      foreign key ("idUser") references public."User" ("idUser")
                                          match simple on update no action on delete no action
);


create table public."User" (
                               "idUser" integer primary key not null default nextval('"User_idUser_seq"'::regclass),
                               "firstName" character varying(255) not null,
                               "lastName" character varying(255) not null,
                               email character varying(255) not null,
                               password character varying(255) not null
);

