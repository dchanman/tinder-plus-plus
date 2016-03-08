# How to import the schema into Oracle

### 1. Open a terminal connection to the UBC servers (PuTTY, ssh)
### 2. Navigate to the `tinder-plus-plus/sql/` directory
```sh
cd tinder-plus-plus/sql
```

Obviously if you don't have the tinder-plus-plus repo cloned, you gotta go do that.

```sh
git clone https://github.com/dchanman/tinder-plus-plus.git
cd tinder-plus-plus/sql
```

### 3. Sign into Oracle with the following:

```sh

r2d2@bowen:~$ sqlplus ora_r2d2@ug

Enter password: a12341234
```

Obviously, replace the `r2d2` in the username `ora_r2d2@ug` with your ugrad username.  
Your password is `a` plus your student number.

### 4. Import the tables into your SQL servers
Run the following command in the server

```
SQL> start schema
```

You might see some errors about dropping tables that don't exist. That's fine. As long as there are no problems with the table creation, you're okay. Run the command a few times if you want to feel safe. Otherwise, you're done now and you have the tables in your Oracle DB.

### 5. Some useful tips with Oracle
* Quit the Oracle shell with `QUIT`
* You can run SQL DDL commands as we learned in class
* `describe TABLENAME` shows you how tables are defined. Try `describe Users` or `describe SuggestedBy` as an example.