PGDMP                      }           event_managementf    17.2    17.2 O    ^           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            _           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            `           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            a           1262    42001    event_managementf    DATABASE     �   CREATE DATABASE event_managementf WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'French_Morocco.1252';
 !   DROP DATABASE event_managementf;
                     postgres    false                        2615    2200    public    SCHEMA        CREATE SCHEMA public;
    DROP SCHEMA public;
                     pg_database_owner    false            b           0    0    SCHEMA public    COMMENT     6   COMMENT ON SCHEMA public IS 'standard public schema';
                        pg_database_owner    false    4            �            1259    42003    users    TABLE       CREATE TABLE public.users (
    id integer NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    first_name character varying(100),
    last_name character varying(100),
    role character varying(50) NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    is_banned boolean DEFAULT false,
    CONSTRAINT users_role_check CHECK (((role)::text = ANY ((ARRAY['admin'::character varying, 'organizer'::character varying, 'participant'::character varying])::text[])))
);
    DROP TABLE public.users;
       public         heap r       postgres    false    4            �            1259    42015    admins    TABLE     �   CREATE TABLE public.admins (
    admin_level integer NOT NULL,
    CONSTRAINT admins_admin_level_check CHECK (((admin_level >= 1) AND (admin_level <= 3)))
)
INHERITS (public.users);
    DROP TABLE public.admins;
       public         heap r       postgres    false    218    4            �            1259    42042 
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
       public               postgres    false    4    223            c           0    0    categories_id_seq    SEQUENCE OWNED BY     G   ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;
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
    tickets_sold integer DEFAULT 0,
    image character varying(100)
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
       public               postgres    false    225    4            d           0    0    events_id_seq    SEQUENCE OWNED BY     ?   ALTER SEQUENCE public.events_id_seq OWNED BY public.events.id;
          public               postgres    false    224            �            1259    42024 
   organizers    TABLE     �   CREATE TABLE public.organizers (
    company_name character varying(255),
    website character varying(255)
)
INHERITS (public.users);
    DROP TABLE public.organizers;
       public         heap r       postgres    false    218    4            �            1259    42032    participants    TABLE     w   CREATE TABLE public.participants (
    phone_number character varying(20),
    address text
)
INHERITS (public.users);
     DROP TABLE public.participants;
       public         heap r       postgres    false    218    4            �            1259    42110    promo_codes    TABLE     �  CREATE TABLE public.promo_codes (
    id integer NOT NULL,
    event_id integer,
    code character varying(50) NOT NULL,
    discount_percentage integer NOT NULL,
    valid_from timestamp without time zone,
    valid_to timestamp without time zone,
    max_uses integer DEFAULT 0,
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
       public               postgres    false    231    4            e           0    0    promo_codes_id_seq    SEQUENCE OWNED BY     I   ALTER SEQUENCE public.promo_codes_id_seq OWNED BY public.promo_codes.id;
          public               postgres    false    230            �            1259    42090    reservations    TABLE     �  CREATE TABLE public.reservations (
    id integer NOT NULL,
    user_id integer,
    ticket_id integer,
    reservation_date timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    status character varying(20) DEFAULT 'active'::character varying,
    promo_code_id integer,
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
       public               postgres    false    229    4            f           0    0    reservations_id_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.reservations_id_seq OWNED BY public.reservations.id;
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
       public               postgres    false    4    227            g           0    0    tickets_id_seq    SEQUENCE OWNED BY     A   ALTER SEQUENCE public.tickets_id_seq OWNED BY public.tickets.id;
          public               postgres    false    226            �            1259    42002    users_id_seq    SEQUENCE     �   CREATE SEQUENCE public.users_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.users_id_seq;
       public               postgres    false    218    4            h           0    0    users_id_seq    SEQUENCE OWNED BY     =   ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;
          public               postgres    false    217                       2604    42018 	   admins id    DEFAULT     e   ALTER TABLE ONLY public.admins ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 8   ALTER TABLE public.admins ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    219    217            �           2604    42019    admins created_at    DEFAULT     V   ALTER TABLE ONLY public.admins ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;
 @   ALTER TABLE public.admins ALTER COLUMN created_at DROP DEFAULT;
       public               postgres    false    219            �           2604    42135    admins is_banned    DEFAULT     I   ALTER TABLE ONLY public.admins ALTER COLUMN is_banned SET DEFAULT false;
 ?   ALTER TABLE public.admins ALTER COLUMN is_banned DROP DEFAULT;
       public               postgres    false    219            �           2604    42045    categories id    DEFAULT     n   ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);
 <   ALTER TABLE public.categories ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    222    223    223            �           2604    42056 	   events id    DEFAULT     f   ALTER TABLE ONLY public.events ALTER COLUMN id SET DEFAULT nextval('public.events_id_seq'::regclass);
 8   ALTER TABLE public.events ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    224    225    225            �           2604    42027    organizers id    DEFAULT     i   ALTER TABLE ONLY public.organizers ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 <   ALTER TABLE public.organizers ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    217    220            �           2604    42028    organizers created_at    DEFAULT     Z   ALTER TABLE ONLY public.organizers ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;
 D   ALTER TABLE public.organizers ALTER COLUMN created_at DROP DEFAULT;
       public               postgres    false    220            �           2604    42136    organizers is_banned    DEFAULT     M   ALTER TABLE ONLY public.organizers ALTER COLUMN is_banned SET DEFAULT false;
 C   ALTER TABLE public.organizers ALTER COLUMN is_banned DROP DEFAULT;
       public               postgres    false    220            �           2604    42035    participants id    DEFAULT     k   ALTER TABLE ONLY public.participants ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 >   ALTER TABLE public.participants ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    221    217            �           2604    42036    participants created_at    DEFAULT     \   ALTER TABLE ONLY public.participants ALTER COLUMN created_at SET DEFAULT CURRENT_TIMESTAMP;
 F   ALTER TABLE public.participants ALTER COLUMN created_at DROP DEFAULT;
       public               postgres    false    221            �           2604    42137    participants is_banned    DEFAULT     O   ALTER TABLE ONLY public.participants ALTER COLUMN is_banned SET DEFAULT false;
 E   ALTER TABLE public.participants ALTER COLUMN is_banned DROP DEFAULT;
       public               postgres    false    221            �           2604    42113    promo_codes id    DEFAULT     p   ALTER TABLE ONLY public.promo_codes ALTER COLUMN id SET DEFAULT nextval('public.promo_codes_id_seq'::regclass);
 =   ALTER TABLE public.promo_codes ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    231    230    231            �           2604    42093    reservations id    DEFAULT     r   ALTER TABLE ONLY public.reservations ALTER COLUMN id SET DEFAULT nextval('public.reservations_id_seq'::regclass);
 >   ALTER TABLE public.reservations ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    228    229    229            �           2604    42077 
   tickets id    DEFAULT     h   ALTER TABLE ONLY public.tickets ALTER COLUMN id SET DEFAULT nextval('public.tickets_id_seq'::regclass);
 9   ALTER TABLE public.tickets ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    227    226    227            |           2604    42006    users id    DEFAULT     d   ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
 7   ALTER TABLE public.users ALTER COLUMN id DROP DEFAULT;
       public               postgres    false    217    218    218            O          0    42015    admins 
   TABLE DATA           v   COPY public.admins (id, email, password, first_name, last_name, role, created_at, admin_level, is_banned) FROM stdin;
    public               postgres    false    219   ba       S          0    42042 
   categories 
   TABLE DATA           ;   COPY public.categories (id, name, description) FROM stdin;
    public               postgres    false    223   �a       U          0    42053    events 
   TABLE DATA           �   COPY public.events (id, organizer_id, category_id, title, description, event_date, location, total_tickets, price, is_approved, created_at, tickets_sold, image) FROM stdin;
    public               postgres    false    225   >b       P          0    42024 
   organizers 
   TABLE DATA           �   COPY public.organizers (id, email, password, first_name, last_name, role, created_at, company_name, website, is_banned) FROM stdin;
    public               postgres    false    220   �c       Q          0    42032    participants 
   TABLE DATA           �   COPY public.participants (id, email, password, first_name, last_name, role, created_at, phone_number, address, is_banned) FROM stdin;
    public               postgres    false    221   �f       [          0    42110    promo_codes 
   TABLE DATA           n   COPY public.promo_codes (id, event_id, code, discount_percentage, valid_from, valid_to, max_uses) FROM stdin;
    public               postgres    false    231   Eg       Y          0    42090    reservations 
   TABLE DATA           g   COPY public.reservations (id, user_id, ticket_id, reservation_date, status, promo_code_id) FROM stdin;
    public               postgres    false    229   �g       W          0    42074    tickets 
   TABLE DATA           F   COPY public.tickets (id, event_id, ticket_number, status) FROM stdin;
    public               postgres    false    227   Nh       N          0    42003    users 
   TABLE DATA           h   COPY public.users (id, email, password, first_name, last_name, role, created_at, is_banned) FROM stdin;
    public               postgres    false    218   j       i           0    0    categories_id_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.categories_id_seq', 2, true);
          public               postgres    false    222            j           0    0    events_id_seq    SEQUENCE SET     <   SELECT pg_catalog.setval('public.events_id_seq', 26, true);
          public               postgres    false    224            k           0    0    promo_codes_id_seq    SEQUENCE SET     @   SELECT pg_catalog.setval('public.promo_codes_id_seq', 5, true);
          public               postgres    false    230            l           0    0    reservations_id_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.reservations_id_seq', 13, true);
          public               postgres    false    228            m           0    0    tickets_id_seq    SEQUENCE SET     =   SELECT pg_catalog.setval('public.tickets_id_seq', 53, true);
          public               postgres    false    226            n           0    0    users_id_seq    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.users_id_seq', 35, true);
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
       public               postgres    false    4773    223    225            �           2606    42129    events events_organizer_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_organizer_id_fkey FOREIGN KEY (organizer_id) REFERENCES public.users(id) ON DELETE CASCADE;
 I   ALTER TABLE ONLY public.events DROP CONSTRAINT events_organizer_id_fkey;
       public               postgres    false    225    218    4769            �           2606    42119 %   promo_codes promo_codes_event_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.promo_codes
    ADD CONSTRAINT promo_codes_event_id_fkey FOREIGN KEY (event_id) REFERENCES public.events(id) ON DELETE CASCADE;
 O   ALTER TABLE ONLY public.promo_codes DROP CONSTRAINT promo_codes_event_id_fkey;
       public               postgres    false    4775    231    225            �           2606    42138 ,   reservations reservations_promo_code_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_promo_code_id_fkey FOREIGN KEY (promo_code_id) REFERENCES public.promo_codes(id) ON DELETE SET NULL;
 V   ALTER TABLE ONLY public.reservations DROP CONSTRAINT reservations_promo_code_id_fkey;
       public               postgres    false    229    4788    231            �           2606    42104 (   reservations reservations_ticket_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_ticket_id_fkey FOREIGN KEY (ticket_id) REFERENCES public.tickets(id) ON DELETE CASCADE;
 R   ALTER TABLE ONLY public.reservations DROP CONSTRAINT reservations_ticket_id_fkey;
       public               postgres    false    229    4779    227            �           2606    42099 &   reservations reservations_user_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_user_id_fkey FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;
 P   ALTER TABLE ONLY public.reservations DROP CONSTRAINT reservations_user_id_fkey;
       public               postgres    false    229    4769    218            �           2606    42084    tickets tickets_event_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.tickets
    ADD CONSTRAINT tickets_event_id_fkey FOREIGN KEY (event_id) REFERENCES public.events(id) ON DELETE CASCADE;
 G   ALTER TABLE ONLY public.tickets DROP CONSTRAINT tickets_event_id_fkey;
       public               postgres    false    227    4775    225            O   ]   x�%�1
�  ��{�.���E�Tghm54%�:~Co~֗t.ᵥ� \-m��7��S/����l%���@�&.�#���QR���V@p�]0�>=Ew      S   _   x�]��� �3����
����'!�bh1��(��b���{���xS��7A��r��Z/�������[�~�(9@5f��0�m�~������:)V      U   R  x����n�0���S��'m�ۍ]�M�v�4���
h�vc���0@��e%q���
 �EӪr�*�@�ddhD��I��&��� h����	�BI1I��7	[����ξ�1zNĒ�\��z���<�`��b۪�:_���U*?<�y�n˺����F(��A�s�-�p3D�0��v��MArA��Bb��� B $M�6S(7��:u��R�i�+�LVh��!���6�s`6�.��z�P�t�KE��D��(�Q�Q�o�}:Z���#�C^?ukS6���X��q��9Н��g���<��wH�|�>����+H��G������(�Z��      P     x�u�Is�@�s�Sx�u�^ �S�J��5�hE@>��e���*N��׿��WM@�,����҈C79���!�R��U�y̒0Γ��� "�@�&�u��T�DU1"�����H��E��z���*n[y?���0�$���D�^�'�=F����c#k�O�ahFpz�����8M�.x��V��ͺ�Y\OJ���J3�q&|_�G����	�*�i�
~.߾�A>o���͗k�1���E����V�鬍�oG�Ъ�@=�Y�l�ӣt�s�s�m:���v��UGJ��9���6eG���xI��9��m"�-g�2U�gRr�xw���yv}M���/"���x���8�ނ��d]Ҡ�Q��`�|�yQ�(%���`.^��.�"�K5疌&�Kh��� o�
sH�q=�#�ޕ�Ǐ�ߙ��u�D��H�'��d�9+m�䫅½�O�h�G5zM��:��-w��U&��i4Xe$�5=n��]������� k������z�gW�
?�ID̊$�׃w�2�NkW���<�k�[8��R���O_��T�G�¤�d��|�{2?����� eY!\����O�%�*P�(�
8��s���ʌe7lBH��:�I{�׏F�Xt_���R6�Ǎ��gC���h=3x�@��<�Q�$Io��n��cʲ��p��|�d��g�'���Σg��.��(�<L؜h�b4�x���7�?Pb.at��&X���1�%���H��K�m�1RUMV�>a�Q����4v?|?����/��      Q   v   x��A�  ���>�X�BOF�>�ˆ�������;���Yn�����c� QO�4����8x$�53ܥɞcnTv@��hp�8��1�.h����<]�>��$���*���Z)��"�      [   E   x�3�42�t-Q(,�THJM,ILUH-Q�/(���K�4�4202�50�54W00�#��%B��Đ+F��� WUU      Y   �   x�m�;�0E�z��l ��<c�"XA�(�@BT�����@�wt����ˈ<L����Y-0/��k��D@�V� ��Y\ؼ�u���j¾�=ذ�b�Ҳ�!��[;��ؤ�a���4
�hv׶���X��z�p�y��X3!ّ����k��`6�&����Rz�M�      W   �  x�mӻj$1���]�HuQIa�Z�8u�d��`����fa�8N�!}=�6�^��kʹl����ǟ[����Tm�t�F�+�P(�A��Y���L��?�������L�]��5M�%I_wI�%%o���#��'i��M�j�I�!l֥Íc��^�~����P
O/�q�d�1l�a���a3�=u�th,眖�3"����&�6����&�6�=oMhmb�$�M�mz���6���KR�܄�֮u��&���.'Nn�K*^�~��yq�A�:�D^�Q��"/�K��h�ʺ[	34R�#a�F�#aŦ�o�WlF�06h4�#��6�
#�M�q$����H�`3WF"]��q$��������k�#��c�8A�z�G"�m�[� ��^�H���G�n��H�[.G�(��q$��e�#y�u�ݾ /<�t      N   �  x�}�Kw�J���Wd�������
&�G��<T�_�`:���x�b �j��j�}6Ksp!�G�D1�?�	��T���oP�f���$^v%z��Y�R�&¦��[FN�Qй����F!	��	Mе*�oe���,����dD���;$���T��R)��L:��>C`��y�sܻ�l`m�da������G��:�]�����N��b��y��Kf�I]��͹_�{(벬C���6������]"�/"��xQ�򃏤n�ƒ�GY�g_�F���MELmkC��\����.��^z����.�b26vb8�*��7��/�A�-�m�I����4�����^f:QuD՚���[.˟yX�el��vA�����V[��ݒ�r�}��
f��.��i�6����i�N��R�����Pө��C�
[Ydi�Ǹ�w<;~��x��Yu�f�ɞ��k�:�G�Q�m�5� s��2��X=̥�!��O�<�o6� �@&��)R��O?Z�8����'J�-��TS�N�=,�X���لT�<�G����vaY�l�0�ҫ�E��ѧ�b�v]�z�n�X'P�h�(4��R�����U��6A.W]��퐨;&�1���{�tl��}6���z�JW��i�L������"q�~�Dޑ�aDk5R�5�7��ꨘI:��R���iTj���eX���Q>Zx���4pR�w�K�hs��M&�c0�!TZ)���l�tsل��f,L�fYVj�S�_?�$A�F���֬��1!i����o̓���P5�E(��&�-B�v~1�7I�Q"Oj��~�|��ˡ����O^��6�t׉�%�h,��\D����B܎/Ԑ J�Y�-�&e��_(���i��@q;��q�����	vHg�|s͓��L��Y+σӠ�y}u�1/>Nrs:l��� )���e)����7��d_DU&y��a=腮�_O{N����Eo���t^�L��EzҬ,
�$R/�w7����IJ�k������ ?�7h�"Y��{"'�k۵�%�{�C[��~]w��t�L�0J�#͒f�tE&��$�
�ޣ��� �5������=o�hD�PE�>�-?I��):��0��4�+�?�;̪�YW@����{:�fih����s=�1U�ؖQϢ�7�;����5���P�Pֺ�_pww���~�     