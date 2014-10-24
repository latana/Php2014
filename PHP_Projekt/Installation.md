
## Installation localt

1. Ladda hem MyFace och lägg filerna på lämplig platts.
2. Ladda upp filen "myface.sql" till din lokala databas och se till att den exekvera.
3. Navigera till models/DAL/ i din MyFace katalog och öppna filen connectDB.php och se till att kontaktsträngen stämmer. Den bör se ut så här /** $this- > connectDB = new \msqli("127.0.0.1", "root", "skriv databaslösenord här", "Databasnamn här" 3306) **/
4. Vill du ändra Administratörens namn så går du till settings.php och ändrar variabeln $admin till vad du önskar.
5. Lycka till!
