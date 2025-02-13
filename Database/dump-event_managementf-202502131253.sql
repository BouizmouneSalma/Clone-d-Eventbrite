PGDMP  &    5                }           event_managementf    17.2    17.2 K    X           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            Y           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            Z           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            [           1262    42001    event_managementf    DATABASE     �   CREATE DATABASE event_managementf WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'French_Morocco.1252';
 !   DROP DATABASE event_managementf;
                     postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
                     pg_database_owner    false            \           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                        pg_database_owner    false    4            �            1259    42003    users    TABLE     �  CREATE TABLE public.users (
    id integer NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    first_name character varying(100),
    last_name character varying(100),
    role character varying(50) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT users_role_check CHECK (((role)::text = ANY ((ARRAY['admin'::character varying, 'organizer'::character varying, 'participant'::character varying])::text[])))
);
    DROP TABLE public.users;
       public         heap r       postgres    false    4            �            1259    42015    admins    TABLE     �   CREATE TABLE public.admins (
    admin_level integer NOT NULL,
    CONSTRAINT admins_admin_level_check CHECK (((admin_level >= 1) AND (admin_level <= 3)))
)
INHERITS (public.users);
    DROP TABLE public.admins;
       public         heap r       postgres    false    4    218            �            1259    42042 
   categories    TABLE     |   CREATE TABLE public.categories (
    id integer NOT NULL,
    name character varying(100) NOT NULL,
    description text
);
    DROP TABLE public.categories;
       public         heap r       postgres    false    4            �            1259    42041    categories_id_seq    SEQUENCE     �   CREATE SEQUENCE public.categories_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.categories_id_seq;
       public               postgres    false    4    223            ]           0    0    categories_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;
          public               postgres    false    222            �            1259    42053    events    TABLE     �  CREATE TABLE public.events (
    id integer NOT NULL,
    organizer_id integer,
    category_id integer,
    title character varying(255) NOT NULL,
    description text,
    event_date timestamp without time zone NOT NULL,
    location character varying(255),
    total_tickets integer NOT NULL,
    price numeric(10,2) NOT NULL,
    is_approved boolean DEFAULT false,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    tickets_sold integer DEFAULT 0
);
    DROP TABLE public.events;
       public         heap r       postgres    false    4            �            1259    42052    events_id_seq    SEQUENCE     �   CREATE SEQUENCE public.events_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.events_id_seq;
       public               postgres    false    225    4            ^           0    0    events_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.events_id_seq OWNED BY public.events.id;
          public               postgres    false    224            �            1259    42024 
   organizers    TABLE     �   CREATE TABLE public.organizers (
    company_name character varying(255),
    website character varying(255)
)
INHERITS (public.users);
    DROP TABLE public.organizers;
       public         heap r       postgres    false    4    218            �            1259    42032    participants    TABLE     w   CREATE TABLE public.participants (
    phone_number character varying(20),
    address text
)
INHERITS (public.users);
     DROP TABLE public.participants;
       public         heap r       postgres    false    218    4            �            1259    42110    promo_codes    TABLE     x  CREATE TABLE public.promo_codes (
    id integer NOT NULL,
    event_id integer,
    code character varying(50) NOT NULL,
    discount_percentage integer NOT NULL,
    valid_from timestamp without time zone,
    valid_to timestamp without time zone,
    CONSTRAINT promo_codes_discount_percentage_check CHECK (((discount_percentage >= 1) AND (discount_percentage <= 100)))
);
    DROP TABLE public.promo_codes;
       public         heap r       postgres    false    4            �            1259    42109    promo_codes_id_seq    SEQUENCE     �   CREATE SEQUENCE public.promo_codes_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.promo_codes_id_seq;
       public               postgres    false    4    231            _           0    0    promo_codes_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.promo_codes_id_seq OWNED BY public.promo_codes.id;
          public               postgres    false    230            �            1259    42090    reservations    TABLE     �  CREATE TABLE public.reservations (
    id integer NOT NULL,
    user_id integer,
    ticket_id integer,
    reservation_date timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    status character varying(20) DEFAULT 'active'::character varying,
    CONSTRAINT reservations_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'canceled'::character varying])::text[])))
);
     DROP TABLE public.reservations;
       public         heap r       postgres    false    4            �            1259    42089    reservations_id_seq    SEQUENCE     �   CREATE SEQUENCE public.reservations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.reservations_id_seq;
       public               postgres    false    4    229            `           0    0    reservations_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.reservations_id_seq OWNED BY public.reservations.id;
          public               postgres    false    228            �            1259    42074    tickets    TABLE     z  CREATE TABLE public.tickets (
    id integer NOT NULL,
    event_id integer,
    ticket_number character varying(50) NOT NULL,
    status character varying(20) DEFAULT 'available'::character varying,
    CONSTRAINT tickets_status_check CHECK (((status)::text = ANY ((ARRAY['available'::character varying, 'sold'::character varying, 'reserved'::character varying])::text[])))
);
    DROP TABLE public.tickets;
       public         heap r       postgres    false    4            �            1259    42073    tickets_id_seq    SEQUENCE     �   CREATE SEQUENCE public.tickets_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.tickets_id_seq;
       public               postgres    false    4    227            a           0    0    tickets_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.tickets_id_seq OWNED BY public.tickets.id;
          public               postgres    false    226            �            1259    42002    users_id_seq    SEQUENCE     �   CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.users_id_seq;
       public               postgres    false    4    218            b           0    0    users_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;
          public               postgres    false    217            ~           2604    42018 	   admins id    DEFAULT     e   ALTER TABLE ONLY public.admins ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 8   ALTER TABLE public.admins ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    217    219                       2604    42019    admins created_at    DEFAULT     V   ALTER TABLE ONLY public.admins ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;
 @   ALTER TABLE public.admins ALTER COLUMN created_at DROP DEFAULT;
       public               postgres    false    219            �           2604    42045    categories id    DEFAULT     n   ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);
 <   ALTER TABLE public.categories ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    222    223    223            �           2604    42056 	   events id    DEFAULT     f   ALTER TABLE ONLY public.events ALTER COLUMN id SET DEFAULT nextval('public.events_id_seq'::regclass);
 8   ALTER TABLE public.events ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    225    224    225            �           2604    42027    organizers id    DEFAULT     i   ALTER TABLE ONLY public.organizers ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 <   ALTER TABLE public.organizers ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    220    217            �           2604    42028    organizers created_at    DEFAULT     Z   ALTER TABLE ONLY public.organizers ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;
 D   ALTER TABLE public.organizers ALTER COLUMN created_at DROP DEFAULT;
       public               postgres    false    220            �           2604    42035    participants id    DEFAULT     k   ALTER TABLE ONLY public.participants ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 >   ALTER TABLE public.participants ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    217    221            �           2604    42036    participants created_at    DEFAULT     \   ALTER TABLE ONLY public.participants ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;
 F   ALTER TABLE public.participants ALTER COLUMN created_at DROP DEFAULT;
       public               postgres    false    221            �           2604    42113    promo_codes id    DEFAULT     p   ALTER TABLE ONLY public.promo_codes ALTER COLUMN id SET DEFAULT nextval('public.promo_codes_id_seq'::regclass);
 =   ALTER TABLE public.promo_codes ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    230    231    231            �           2604    42093    reservations id    DEFAULT     r   ALTER TABLE ONLY public.reservations ALTER COLUMN id SET DEFAULT nextval('public.reservations_id_seq'::regclass);
 >   ALTER TABLE public.reservations ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    229    228    229            �           2604    42077 
   tickets id    DEFAULT     h   ALTER TABLE ONLY public.tickets ALTER COLUMN id SET DEFAULT nextval('public.tickets_id_seq'::regclass);
 9   ALTER TABLE public.tickets ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    227    226    227            |           2604    42006    users id    DEFAULT     d   ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 7   ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    217    218    218            I          0    42015    admins 
   TABLE DATA           k   COPY public.admins (id, email, password, first_name, last_name, role, created_at, admin_level) FROM stdin;
    public               postgres    false    219   E[       M          0    42042 
   categories 
   TABLE DATA           ;   COPY public.categories (id, name, description) FROM stdin;
    public               postgres    false    223   �[       O          0    42053    events 
   TABLE DATA           �   COPY public.events (id, organizer_id, category_id, title, description, event_date, location, total_tickets, price, is_approved, created_at, tickets_sold) FROM stdin;
    public               postgres    false    225    \       J          0    42024 
   organizers 
   TABLE DATA           y   COPY public.organizers (id, email, password, first_name, last_name, role, created_at, company_name, website) FROM stdin;
    public               postgres    false    220   �\       K          0    42032    participants 
   TABLE DATA           {   COPY public.participants (id, email, password, first_name, last_name, role, created_at, phone_number, address) FROM stdin;
    public               postgres    false    221   D_       U          0    42110    promo_codes 
   TABLE DATA           d   COPY public.promo_codes (id, event_id, code, discount_percentage, valid_from, valid_to) FROM stdin;
    public               postgres    false    231   �_       S          0    42090    reservations 
   TABLE DATA           X   COPY public.reservations (id, user_id, ticket_id, reservation_date, status) FROM stdin;
    public               postgres    false    229   �_       Q          0    42074    tickets 
   TABLE DATA           F   COPY public.tickets (id, event_id, ticket_number, status) FROM stdin;
    public               postgres    false    227   ?`       H          0    42003    users 
   TABLE DATA           ]   COPY public.users (id, email, password, first_name, last_name, role, created_at) FROM stdin;
    public               postgres    false    218   r`       c           0    0    categories_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.categories_id_seq', 2, true);
          public               postgres    false    222            d           0    0    events_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.events_id_seq', 21, true);
          public               postgres    false    224            e           0    0    promo_codes_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.promo_codes_id_seq', 3, true);
          public               postgres    false    230            f           0    0    reservations_id_seq    SEQUENCE SET     A   SELECT pg_catalog.setval('public.reservations_id_seq', 6, true);
          public               postgres    false    228            g           0    0    tickets_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.tickets_id_seq', 3, true);
          public               postgres    false    226            h           0    0    users_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.users_id_seq', 29, true);
          public               postgres    false    217            �           2606    42051    categories categories_name_key 
   CONSTRAINT     Y   ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_name_key UNIQUE (name);
 H   ALTER TABLE ONLY public.categories DROP CONSTRAINT categories_name_key;
       public                 postgres    false    223            �           2606    42049    categories categories_pkey 
   CONSTRAINT     X   ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);
 D   ALTER TABLE ONLY public.categories DROP CONSTRAINT categories_pkey;
       public                 postgres    false    223            �           2606    42062    events events_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.events DROP CONSTRAINT events_pkey;
       public                 postgres    false    225            �           2606    42118     promo_codes promo_codes_code_key 
   CONSTRAINT     [   ALTER TABLE ONLY public.promo_codes
    ADD CONSTRAINT promo_codes_code_key UNIQUE (code);
 J   ALTER TABLE ONLY public.promo_codes DROP CONSTRAINT promo_codes_code_key;
       public                 postgres    false    231            �           2606    42116    promo_codes promo_codes_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.promo_codes
    ADD CONSTRAINT promo_codes_pkey PRIMARY KEY (id);
 F   ALTER TABLE ONLY public.promo_codes DROP CONSTRAINT promo_codes_pkey;
       public                 postgres    false    231            �           2606    42098    reservations reservations_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.reservations DROP CONSTRAINT reservations_pkey;
       public                 postgres    false    229            �           2606    42081    tickets tickets_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.tickets DROP CONSTRAINT tickets_pkey;
       public                 postgres    false    227            �           2606    42083 !   tickets tickets_ticket_number_key 
   CONSTRAINT     e   ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_ticket_number_key UNIQUE (ticket_number);
 K   ALTER TABLE ONLY public.tickets DROP CONSTRAINT tickets_ticket_number_key;
       public                 postgres    false    227            �           2606    42014    users users_email_key 
   CONSTRAINT     Q   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);
 ?   ALTER TABLE ONLY public.users DROP CONSTRAINT users_email_key;
       public                 postgres    false    218            �           2606    42012    users users_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public                 postgres    false    218            �           1259    42125    idx_events_organizer_id    INDEX     R   CREATE INDEX idx_events_organizer_id ON public.events USING btree (organizer_id);
 +   DROP INDEX public.idx_events_organizer_id;
       public                 postgres    false    225            �           1259    42127    idx_reservations_user_id    INDEX     T   CREATE INDEX idx_reservations_user_id ON public.reservations USING btree (user_id);
 ,   DROP INDEX public.idx_reservations_user_id;
       public                 postgres    false    229            �           1259    42126    idx_tickets_event_id    INDEX     L   CREATE INDEX idx_tickets_event_id ON public.tickets USING btree (event_id);
 (   DROP INDEX public.idx_tickets_event_id;
       public                 postgres    false    227            �           1259    42124    idx_users_email    INDEX     B   CREATE INDEX idx_users_email ON public.users USING btree (email);
 #   DROP INDEX public.idx_users_email;
       public                 postgres    false    218            �           1259    42040    unique_email    INDEX     F   CREATE UNIQUE INDEX unique_email ON public.users USING btree (email);
     DROP INDEX public.unique_email;
       public                 postgres    false    218            �           2606    42068    events events_category_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_category_id_fkey FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE SET NULL;
 H   ALTER TABLE ONLY public.events DROP CONSTRAINT events_category_id_fkey;
       public               postgres    false    4768    225    223            �           2606    42129    events events_organizer_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_organizer_id_fkey FOREIGN KEY (organizer_id) REFERENCES public.users(id) ON DELETE CASCADE;
 I   ALTER TABLE ONLY public.events DROP CONSTRAINT events_organizer_id_fkey;
       public               postgres    false    4764    225    218            �           2606    42119 %   promo_codes promo_codes_event_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.promo_codes
    ADD CONSTRAINT promo_codes_event_id_fkey FOREIGN KEY (event_id) REFERENCES public.events(id) ON DELETE CASCADE;
 O   ALTER TABLE ONLY public.promo_codes DROP CONSTRAINT promo_codes_event_id_fkey;
       public               postgres    false    231    225    4770            �           2606    42104 (   reservations reservations_ticket_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_ticket_id_fkey FOREIGN KEY (ticket_id) REFERENCES public.tickets(id) ON DELETE CASCADE;
 R   ALTER TABLE ONLY public.reservations DROP CONSTRAINT reservations_ticket_id_fkey;
       public               postgres    false    229    227    4774            �           2606    42099 &   reservations reservations_user_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;
 P   ALTER TABLE ONLY public.reservations DROP CONSTRAINT reservations_user_id_fkey;
       public               postgres    false    229    4764    218            �           2606    42084    tickets tickets_event_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_event_id_fkey FOREIGN KEY (event_id) REFERENCES public.events(id) ON DELETE CASCADE;
 G   ALTER TABLE ONLY public.tickets DROP CONSTRAINT tickets_event_id_fkey;
       public               postgres    false    227    225    4770            I   \   x�3�LL���sH�H�-�I�K����H,�HM)H,..�/J1�t��LN���,ɀ��4202�50�54R02�2��26�3414�4�4����� 	�      M   _   x�]��� �3����
����'!�bh1��(��b���{���xS��7A��r��Z/�������[�~�(9@5f��0�m�~������:)V      O   �   x��O�
�0<o�"?в�d��՛^D��ņJ%����*� �23�08���K�&$�k�a'�+�����6�@__��|��X>�R�0�ɴVP�l}�P�?*m+B�,�^*� URz<������?����+8�`�'�j��bB�6�%�V*�ޞ9Ka      J   ^  x�u�[s�0���)����$�ꥺ��[���K� Q A�O�����l�L��Lr~��h�k�=���iĠ'b�<d~J���AO�`,�$�� +X{T�#�?0��ib�@
��Ⱦ�RJ��V��n����ԏy�t�)�>z>��RBg����ާ� �DЮ��n�_��u)فf�j��e=�1ޟ��a`�f4���������
4H����Ҭ��_��[�}�fp��<�l�66?��k��F&7K�g�,�׶}R� �\���Iơ�黠�Ŵ�a)
TM�iR���@6;�W�{���_�gpr2�ס�č�r����F�Bl��ao����*=����������)�B&$��T`�~���uF/�Ư99�O׌ҋm�ϸ`Da���J��j'ʶ���`�2�P�x��K4K5��(X'$Њ��DO7	O�ٿ���8����s��3�z�pm-,8������hX8�ccl���h@)x��F!�B�Eth�!��=�L�>�+�;(X7Y,�yyP�{}�^����$<1A��Ȝ�=(��ľd��إ��9����՘����F�:�c�7�;l�Z� ~�%Q      K   u   x��A�  ���>�X�BO�&�}�����RS�ogY�G{�XǺC��xm��Yeu�L$[fxH=4�#�ܨ����hq@;c�]��5�u��}�7I��%T"��VJ���"�      U      x������ � �      S   I   x�3�4�4�4202�50�54R02�26�26�3��010�LL.�,K�2�44�Phbdeb�ghaffa
S���� ��      Q   #   x�3�4�q��500�,J-N-*KM����� ZL�      H   @  x���K��8 ���W���IH��j_��m�(E�lD@y�C�_ߔ5s�Όէ���{?.���>O»����H@7�A��@x/�:�=z��4H�4���2��e��o
20�����I*�x^�n������W6������z��� S�F���e�a��<��/�yA��v]����&�3����K��-L5cˬ�9>[=��׽���|���0]0�q�&�oH6�eB1Ck~�\�%��}BAX!T��~(�u�|���U�"H�L%D�UQ<y����}�s��5�(�����h"L~V뮻����4cZY��1�2�!�L!�ۧ��TP��I���~����DXhϒ ��q����Q'�A"\�~@��b����1�5Ͻ��H4_P� �H�5UB���O���뺯a��_��Y�6�ī'��f�ۍUj�^�޲��f޲�Xaz"��ԧ�H6d�@*:º&a����W:Q\�#y�Pw��7y����Ӽف��Щ+g��8����&���E��������5@J��)V��߄�?��i�$B�wfA�����fsu ���p���k����ܤ�><o��a�u&D����{��?p�bR��IX�}��v�jE��U��[�����Рҡu?f[���Yͧ�2�������?��;
i� Ș��*ap��8����|��N�;0�>;��5Qlҽ0���h G��r��f���z؀9o]�iѺ��P>'���j�
�f �<�N�}Q�w.x���>�T3���~u+�Y��I�ʠ,�a�[Muw�L���?qm�_yY>�`$��#�Dֈ����$I� 3Ž      