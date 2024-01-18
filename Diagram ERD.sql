--
-- PostgreSQL database dump
--

-- Dumped from database version 16.1 (Debian 16.1-1.pgdg120+1)
-- Dumped by pg_dump version 16.1

-- Started on 2024-01-18 09:02:29 UTC

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 224 (class 1259 OID 16509)
-- Name: Admin; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."Admin" (
    "idAdmin" integer NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    phone character varying(255) NOT NULL,
    "frusionName" character varying(255) NOT NULL
);


ALTER TABLE public."Admin" OWNER TO docker;

--
-- TOC entry 223 (class 1259 OID 16508)
-- Name: Admin_idAdmin_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."Admin_idAdmin_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."Admin_idAdmin_seq" OWNER TO docker;

--
-- TOC entry 3437 (class 0 OID 0)
-- Dependencies: 223
-- Name: Admin_idAdmin_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."Admin_idAdmin_seq" OWNED BY public."Admin"."idAdmin";


--
-- TOC entry 216 (class 1259 OID 16437)
-- Name: Box; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."Box" (
    "idBox" integer NOT NULL,
    "typeBox" character varying(255) NOT NULL,
    "weightBox" double precision NOT NULL,
    "idAdmin" integer NOT NULL
);


ALTER TABLE public."Box" OWNER TO docker;

--
-- TOC entry 215 (class 1259 OID 16436)
-- Name: Box_idBox_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."Box_idBox_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."Box_idBox_seq" OWNER TO docker;

--
-- TOC entry 3438 (class 0 OID 0)
-- Dependencies: 215
-- Name: Box_idBox_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."Box_idBox_seq" OWNED BY public."Box"."idBox";


--
-- TOC entry 222 (class 1259 OID 16495)
-- Name: Comment; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."Comment" (
    "idComment" integer NOT NULL,
    "idPrice" integer NOT NULL,
    comment character varying(500) NOT NULL
);


ALTER TABLE public."Comment" OWNER TO docker;

--
-- TOC entry 221 (class 1259 OID 16494)
-- Name: Comment_idComment_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."Comment_idComment_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."Comment_idComment_seq" OWNER TO docker;

--
-- TOC entry 3439 (class 0 OID 0)
-- Dependencies: 221
-- Name: Comment_idComment_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."Comment_idComment_seq" OWNED BY public."Comment"."idComment";


--
-- TOC entry 218 (class 1259 OID 16449)
-- Name: Fruit; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."Fruit" (
    "idFruit" integer NOT NULL,
    "typeFruit" character varying(255) NOT NULL,
    "idAdmin" integer
);


ALTER TABLE public."Fruit" OWNER TO docker;

--
-- TOC entry 220 (class 1259 OID 16483)
-- Name: FruitPrices; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."FruitPrices" (
    "idPrice" integer NOT NULL,
    "idFruit" integer NOT NULL,
    price double precision NOT NULL,
    "datePrice" date NOT NULL
);


ALTER TABLE public."FruitPrices" OWNER TO docker;

--
-- TOC entry 219 (class 1259 OID 16482)
-- Name: FruitPrices_idPrice_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."FruitPrices_idPrice_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."FruitPrices_idPrice_seq" OWNER TO docker;

--
-- TOC entry 3440 (class 0 OID 0)
-- Dependencies: 219
-- Name: FruitPrices_idPrice_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."FruitPrices_idPrice_seq" OWNED BY public."FruitPrices"."idPrice";


--
-- TOC entry 217 (class 1259 OID 16448)
-- Name: Fruit_idFruit_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."Fruit_idFruit_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."Fruit_idFruit_seq" OWNER TO docker;

--
-- TOC entry 3441 (class 0 OID 0)
-- Dependencies: 217
-- Name: Fruit_idFruit_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."Fruit_idFruit_seq" OWNED BY public."Fruit"."idFruit";


--
-- TOC entry 228 (class 1259 OID 16528)
-- Name: Transaction; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."Transaction" (
    "idTransaction" integer NOT NULL,
    "idUser" integer NOT NULL,
    "idAdmin" integer NOT NULL,
    weight_with_boxes numeric NOT NULL,
    "idBox" integer NOT NULL,
    "numberOfBoxes" integer NOT NULL,
    "idPrice" integer NOT NULL,
    "transactionDate" date NOT NULL,
    weight numeric NOT NULL,
    amount numeric NOT NULL,
    "priceFruit" numeric
);


ALTER TABLE public."Transaction" OWNER TO docker;

--
-- TOC entry 227 (class 1259 OID 16527)
-- Name: Transaction_idTransaction_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."Transaction_idTransaction_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."Transaction_idTransaction_seq" OWNER TO docker;

--
-- TOC entry 3442 (class 0 OID 0)
-- Dependencies: 227
-- Name: Transaction_idTransaction_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."Transaction_idTransaction_seq" OWNED BY public."Transaction"."idTransaction";


--
-- TOC entry 226 (class 1259 OID 16519)
-- Name: User; Type: TABLE; Schema: public; Owner: docker
--

CREATE TABLE public."User" (
    "idUser" integer NOT NULL,
    "firstName" character varying(255) NOT NULL,
    "lastName" character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    "idAdmin" integer
);


ALTER TABLE public."User" OWNER TO docker;

--
-- TOC entry 225 (class 1259 OID 16518)
-- Name: User_idUser_seq; Type: SEQUENCE; Schema: public; Owner: docker
--

CREATE SEQUENCE public."User_idUser_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."User_idUser_seq" OWNER TO docker;

--
-- TOC entry 3443 (class 0 OID 0)
-- Dependencies: 225
-- Name: User_idUser_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: docker
--

ALTER SEQUENCE public."User_idUser_seq" OWNED BY public."User"."idUser";


--
-- TOC entry 230 (class 1259 OID 16591)
-- Name: vwBoxView; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public."vwBoxView" AS
 SELECT "idBox",
    "typeBox",
    "weightBox",
    "idAdmin"
   FROM public."Box";


ALTER VIEW public."vwBoxView" OWNER TO docker;

--
-- TOC entry 229 (class 1259 OID 16587)
-- Name: vwFruitView; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public."vwFruitView" AS
 SELECT f."idFruit",
    f."typeFruit",
    f."idAdmin",
    p."idPrice",
    p.price
   FROM (public."Fruit" f
     LEFT JOIN public."FruitPrices" p ON ((f."idFruit" = p."idFruit")));


ALTER VIEW public."vwFruitView" OWNER TO docker;

--
-- TOC entry 231 (class 1259 OID 24779)
-- Name: vwtransactions; Type: VIEW; Schema: public; Owner: docker
--

CREATE VIEW public.vwtransactions AS
 SELECT t."idTransaction",
    t."idUser",
    t."idAdmin",
    t.weight_with_boxes,
    t."idBox",
    t."numberOfBoxes",
    t."idPrice",
    t."transactionDate",
    t.weight,
    t.amount,
    t."priceFruit",
    u."firstName" AS "userFirstName",
    u."lastName" AS "userLastName",
    u.email AS "userEmail",
    b."typeBox",
    f."typeFruit",
    fp.price AS "fruitPrice",
    fp."datePrice" AS "priceDate"
   FROM ((((public."Transaction" t
     JOIN public."User" u ON ((t."idUser" = u."idUser")))
     JOIN public."Box" b ON ((t."idBox" = b."idBox")))
     JOIN public."FruitPrices" fp ON ((t."idPrice" = fp."idPrice")))
     JOIN public."Fruit" f ON ((fp."idFruit" = f."idFruit")));


ALTER VIEW public.vwtransactions OWNER TO docker;

--
-- TOC entry 3249 (class 2604 OID 16512)
-- Name: Admin idAdmin; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Admin" ALTER COLUMN "idAdmin" SET DEFAULT nextval('public."Admin_idAdmin_seq"'::regclass);


--
-- TOC entry 3245 (class 2604 OID 16440)
-- Name: Box idBox; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Box" ALTER COLUMN "idBox" SET DEFAULT nextval('public."Box_idBox_seq"'::regclass);


--
-- TOC entry 3248 (class 2604 OID 16498)
-- Name: Comment idComment; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Comment" ALTER COLUMN "idComment" SET DEFAULT nextval('public."Comment_idComment_seq"'::regclass);


--
-- TOC entry 3246 (class 2604 OID 16452)
-- Name: Fruit idFruit; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Fruit" ALTER COLUMN "idFruit" SET DEFAULT nextval('public."Fruit_idFruit_seq"'::regclass);


--
-- TOC entry 3247 (class 2604 OID 16486)
-- Name: FruitPrices idPrice; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."FruitPrices" ALTER COLUMN "idPrice" SET DEFAULT nextval('public."FruitPrices_idPrice_seq"'::regclass);


--
-- TOC entry 3251 (class 2604 OID 16531)
-- Name: Transaction idTransaction; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Transaction" ALTER COLUMN "idTransaction" SET DEFAULT nextval('public."Transaction_idTransaction_seq"'::regclass);


--
-- TOC entry 3250 (class 2604 OID 16522)
-- Name: User idUser; Type: DEFAULT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."User" ALTER COLUMN "idUser" SET DEFAULT nextval('public."User_idUser_seq"'::regclass);


--
-- TOC entry 3427 (class 0 OID 16509)
-- Dependencies: 224
-- Data for Name: Admin; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."Admin" ("idAdmin", email, password, phone, "frusionName") FROM stdin;
15	adamnowak@gmail.com	$2y$10$inF6XY.hNwG54PF2MgOHB.qh4kkXzscbF/TIp9od1zIvI2Ou5j4ce	111-222-333	U Nowaka
16	barbarakapusta@gmail.com	$2y$10$ZzRk24Dn5Zt.9tKYut49ZeRltoO0Rcnj8GGsh3imewQGe8kxAJzQu	222-333-444	U Kapusty
\.


--
-- TOC entry 3419 (class 0 OID 16437)
-- Dependencies: 216
-- Data for Name: Box; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."Box" ("idBox", "typeBox", "weightBox", "idAdmin") FROM stdin;
23	czeszka	1.2	13
24	M5	1	13
27	SVZ	1.2	16
28	niemka	2	16
\.


--
-- TOC entry 3425 (class 0 OID 16495)
-- Dependencies: 222
-- Data for Name: Comment; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."Comment" ("idComment", "idPrice", comment) FROM stdin;
1	1	cena potwierdzona przez szefa
\.


--
-- TOC entry 3421 (class 0 OID 16449)
-- Dependencies: 218
-- Data for Name: Fruit; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."Fruit" ("idFruit", "typeFruit", "idAdmin") FROM stdin;
1	malina	\N
42	gruszka	16
43	jagoda	13
44	malina	13
45	jabłko	16
\.


--
-- TOC entry 3423 (class 0 OID 16483)
-- Dependencies: 220
-- Data for Name: FruitPrices; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."FruitPrices" ("idPrice", "idFruit", price, "datePrice") FROM stdin;
1	1	10	2023-12-09
38	42	5	2024-01-08
40	44	5.5	2024-01-09
39	43	11	2024-01-09
41	45	10	2024-01-09
\.


--
-- TOC entry 3431 (class 0 OID 16528)
-- Dependencies: 228
-- Data for Name: Transaction; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."Transaction" ("idTransaction", "idUser", "idAdmin", weight_with_boxes, "idBox", "numberOfBoxes", "idPrice", "transactionDate", weight, amount, "priceFruit") FROM stdin;
130	27	16	23	27	2	38	2024-01-17	20.6	103	5
129	27	16	23	27	2	38	2024-01-17	20.6	103	5
127	27	16	5.6	27	2	41	2024-01-17	3.2	7.36	2.3
128	26	16	56	27	5	41	2024-01-17	50	115	2.3
131	27	16	50	27	2	41	2024-01-17	47.6	476	10
126	27	16	6	27	1	38	2024-01-16	4.8	24	5
97	26	16	23.4	27	2	41	2024-01-09	21	48.3	2.3
105	27	16	45.6	27	4	41	2024-01-11	40.8	93.84	2.3
94	27	16	4.5	27	1	38	2024-01-09	3.3	16.5	5
99	27	16	56.5	27	3	38	2024-01-10	52.9	264.5	5
119	26	16	34.5	27	3	38	2024-01-11	30.9	154.5	5
120	26	16	23.4	27	1	38	2024-01-15	22.2	111	5
110	26	16	12.4	27	2	38	2024-01-11	10	50	5
111	26	16	24.5	27	5	38	2024-01-11	18.5	92.5	5
\.


--
-- TOC entry 3429 (class 0 OID 16519)
-- Dependencies: 226
-- Data for Name: User; Type: TABLE DATA; Schema: public; Owner: docker
--

COPY public."User" ("idUser", "firstName", "lastName", email, password, "idAdmin") FROM stdin;
26	Przemysław	Mazur	pmazur@gmail.com	$2y$10$ZXhqVG60QnyMkZaWsRjCI.jkAiA070vl2QVQaA057SBZDpqPLXJPG	16
24	Bartosz	Niemiec	bniemiec@gmail.com	$2y$10$UOR84JEZ9OArjuVNAeav7eNgGWfAkAsftt0gEQfbXyJ.qzUhR7GOC	13
25	Edyta	Siwko	esiwko@gmail.com	$2y$10$.NsriDB6SDoBxexXp8Hj7.MV0t2pvgoi/E/hissTwcoXbxS5n6dUm	13
27	Karolina	Tyczko	ktyczko@gmail.com	$2y$10$b2xHfsB93xKJpZh6SBGg2e8kNY315VbRuVV0ROy.lFMOjmKTXyxda	16
\.


--
-- TOC entry 3444 (class 0 OID 0)
-- Dependencies: 223
-- Name: Admin_idAdmin_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."Admin_idAdmin_seq"', 24, true);


--
-- TOC entry 3445 (class 0 OID 0)
-- Dependencies: 215
-- Name: Box_idBox_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."Box_idBox_seq"', 31, true);


--
-- TOC entry 3446 (class 0 OID 0)
-- Dependencies: 221
-- Name: Comment_idComment_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."Comment_idComment_seq"', 1, true);


--
-- TOC entry 3447 (class 0 OID 0)
-- Dependencies: 219
-- Name: FruitPrices_idPrice_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."FruitPrices_idPrice_seq"', 47, true);


--
-- TOC entry 3448 (class 0 OID 0)
-- Dependencies: 217
-- Name: Fruit_idFruit_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."Fruit_idFruit_seq"', 51, true);


--
-- TOC entry 3449 (class 0 OID 0)
-- Dependencies: 227
-- Name: Transaction_idTransaction_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."Transaction_idTransaction_seq"', 131, true);


--
-- TOC entry 3450 (class 0 OID 0)
-- Dependencies: 225
-- Name: User_idUser_seq; Type: SEQUENCE SET; Schema: public; Owner: docker
--

SELECT pg_catalog.setval('public."User_idUser_seq"', 28, true);


--
-- TOC entry 3261 (class 2606 OID 16516)
-- Name: Admin idAdmin; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Admin"
    ADD CONSTRAINT "idAdmin" PRIMARY KEY ("idAdmin");


--
-- TOC entry 3253 (class 2606 OID 16442)
-- Name: Box idBox; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Box"
    ADD CONSTRAINT "idBox" PRIMARY KEY ("idBox");


--
-- TOC entry 3259 (class 2606 OID 16502)
-- Name: Comment idComment; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Comment"
    ADD CONSTRAINT "idComment" PRIMARY KEY ("idComment");


--
-- TOC entry 3255 (class 2606 OID 16454)
-- Name: Fruit idFruit; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Fruit"
    ADD CONSTRAINT "idFruit" PRIMARY KEY ("idFruit");


--
-- TOC entry 3257 (class 2606 OID 16488)
-- Name: FruitPrices idPrice; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."FruitPrices"
    ADD CONSTRAINT "idPrice" PRIMARY KEY ("idPrice");


--
-- TOC entry 3265 (class 2606 OID 16533)
-- Name: Transaction idTransaction; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Transaction"
    ADD CONSTRAINT "idTransaction" PRIMARY KEY ("idTransaction");


--
-- TOC entry 3263 (class 2606 OID 16526)
-- Name: User idUser; Type: CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."User"
    ADD CONSTRAINT "idUser" PRIMARY KEY ("idUser");


--
-- TOC entry 3268 (class 2606 OID 16572)
-- Name: Transaction idAdmin; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Transaction"
    ADD CONSTRAINT "idAdmin" FOREIGN KEY ("idAdmin") REFERENCES public."Admin"("idAdmin") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3269 (class 2606 OID 16577)
-- Name: Transaction idBox; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Transaction"
    ADD CONSTRAINT "idBox" FOREIGN KEY ("idBox") REFERENCES public."Box"("idBox") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3266 (class 2606 OID 16562)
-- Name: FruitPrices idFruit; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."FruitPrices"
    ADD CONSTRAINT "idFruit" FOREIGN KEY ("idFruit") REFERENCES public."Fruit"("idFruit") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3267 (class 2606 OID 16503)
-- Name: Comment idPrice; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Comment"
    ADD CONSTRAINT "idPrice" FOREIGN KEY ("idPrice") REFERENCES public."FruitPrices"("idPrice");


--
-- TOC entry 3270 (class 2606 OID 16582)
-- Name: Transaction idPrice; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Transaction"
    ADD CONSTRAINT "idPrice" FOREIGN KEY ("idPrice") REFERENCES public."FruitPrices"("idPrice") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 3271 (class 2606 OID 16567)
-- Name: Transaction idUser; Type: FK CONSTRAINT; Schema: public; Owner: docker
--

ALTER TABLE ONLY public."Transaction"
    ADD CONSTRAINT "idUser" FOREIGN KEY ("idUser") REFERENCES public."User"("idUser") ON UPDATE CASCADE ON DELETE CASCADE;


-- Completed on 2024-01-18 09:02:30 UTC

--
-- PostgreSQL database dump complete
--

