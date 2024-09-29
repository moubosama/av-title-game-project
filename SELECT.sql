SELECT
    ls.user_id,
    CASE
        WHEN DATEDIFF(CURDATE(), ls.attendance_date) > 1 THEN 0 現在の日付とテーブルにある日付の差分を確認
        ELSE ls.current_streak　差分がなければcurrent_streakを返す
    END AS current_streak
FROM (
    SELECT
        sd.user_id,
        sd.attendance_date,
        sd.current_streak
    FROM (
        SELECT
            user_id,
            attendance_date,
            CASE
                WHEN DATEDIFF(attendance_date, LAG(attendance_date, 1) OVER (PARTITION BY user_id ORDER BY attendance_date)) <= 2 THEN @streak := @streak + 1
                ELSE @streak := 1　user_idごとのattendace_dateの手前から昇順　日が２日離れていれば以上であれば連続日数＋１　そうでない場合は１にする
            END AS current_streak
        FROM (
            SELECT
                user_id,
                DATE(date_time) AS attendance_date
            FROM
                user_calendars
            WHERE
                attendance = 3
            GROUP BY
                user_id, DATE(date_time)
        ) AS GroupedAttendance　// 授業に参加したuser
        CROSS JOIN (SELECT @streak := 0) AS var_init　わからん　たぶんすべてのuser_idとattendance_dateを取得？してstreakを０、リセットしている
    ) AS sd
    WHERE
        sd.attendance_date = (
            SELECT MAX(attendance_date) // 最新の授業参加日数
            FROM (
                SELECT
                    user_id,
                    DATE(date_time) AS attendance_date
                FROM
                    user_calendars
                WHERE
                    attendance = 3
                GROUP BY
                    user_id, DATE(date_time)
            ) AS innerGroupedAttendance
            WHERE user_id = sd.user_id　// user_idと上のsb.user_idが一致しているもの
        )
) AS ls
ORDER BY
    ls.user_id;
