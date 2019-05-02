CREATE TABLE users (
    id INTEGER PRIMARY KEY,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    room INTEGER,
    last_time_online TEXT,
    white_cards INTEGER,
    isBoss INTEGER
);

CREATE TABLE rooms (
    id INTEGER PRIMARY KEY,
    name TEXT UNIQUE NOT NULL,
    password TEXT,
    host INTEGER,
    master INTEGER,
    max_points INTEGER,
    last_time_online TEXT,
    black_card INTEGER
);

CREATE TABLE messages (
    user_id INTEGER,
    room_id INTEGER,
    content TEXT,
    created TEXT
);

CREATE TABLE banned (
    user_id INTEGER,
    room_id INTEGER
);

CREATE TABLE white_cards (
    id INTEGER PRIMARY KEY,
    content TEXT
);

CREATE TABLE black_card (
    id INTEGER PRIMARY KEY,
    content TEXT
);

CREATE TABLE user_white_cards (
    user_id INTEGER,
    white_card_id INTEGER
);

CREATE TABLE room_white_card (
    room_id INTEGER,
    white_card_id INTEGER,
    user_id
)