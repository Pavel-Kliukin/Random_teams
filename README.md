# STUDENTS |&#8592; &nbsp;&nbsp; &rarr;| DIVIDER
## This php-app makes random teams from a students list

It takes students names from the Data Base, displays them on the screen and then randomly divides students by the teams.
In this app you can:

- add students to the DB and therefore to the displayed list
- delete students from DB and displayed list
- choose how many students per team you want to display

Some features:

- if you will try to divide students into one person in a team or you will input to the form a negative number or you will input a number exceeding the number of students, you’ll get a message, that “Dividing doesn’t make sense”
- if, after dividing students into teams, one person remains undivided, then he is added to the last group.

### This is how the application works:


https://github.com/Pavel-Kliukin/Random_teams/assets/98514950/f08ca911-194e-4f8c-997d-fd053b9adc9b

## To use this app:
1. Clone this repository to your computer.
2. In your Terminal go to the folder with this app and write command: `docker-compose up` 
3. Create a table "Students" with columns 'id' and 'name' in the DataBase named "phpProjectDB" which is located at http://localhost:9077/ (use name: 'Pavel' and password: '777' to get there).
4. In your browser go to http://localhost:8077/index.php
5. Fill the table with names of your students via phpMyAdmin or form in the application.
