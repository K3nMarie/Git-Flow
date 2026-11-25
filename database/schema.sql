CREATE TABLE IF NOT EXISTS tasks (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    task_name TEXT NOT NULL,
    task_description TEXT DEFAULT '',
    task_status TEXT NOT NULL DEFAULT 'sin hacer',
    task_type TEXT NOT NULL DEFAULT 'Fluida',
    due_date TEXT NOT NULL
);
CREATE TABLE IF NOT EXISTS moodtracker (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    mood_time TEXT NOT NULL,
    mood TEXT NOT NULL
);
CREATE TABLE IF NOT EXISTS journal (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL DEFAULT '',
    content TEXT NOT NULL DEFAULT '',
    entry_date TEXT NOT NULL UNIQUE
);
CREATE TABLE IF NOT EXISTS timer_sessions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    started_at INTEGER NOT NULL,
    total_seconds INTEGER NOT NULL,
    status TEXT NOT NULL DEFAULT 'running'
);
CREATE TABLE IF NOT EXISTS time_entries (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    session_id INTEGER,
    entry_date TEXT NOT NULL,
    study_seconds INTEGER NOT NULL DEFAULT 0,
    break_seconds INTEGER NOT NULL DEFAULT 0
);
