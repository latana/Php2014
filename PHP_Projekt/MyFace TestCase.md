#TestFall

###Testfall 1.1 Misslyckad registrering med blanka fält.
**Input:**
  1. Tomma fält i Username och båda password
  2. Klicka på Register.

**Output:**
  1. Systemet presenterar "Username must have 3 letters and password 6 letters".

###Testfall 1.2 Misslyckad registrering med endast giltigt användarnamn.
**Input:**

1. Username "Svensson"
2. Klicka på Register

**Output:**

1. Systemet presenterar "Username must have 3 letters and password 6 letters".

###Testfall 1.3 Misslyckad registrering Repeat password blankt
**Input:**

1. Username "Svensson"
2. Password "Hemligt"
3. Klicka på Register

**OutPut:**

1. Systemet pressenterar "Password doesn't match".

###Testfall 1.4  Misslyckad registrering för korta uppgifter
**Input:**

1. Username "Ida"
2. Password "Hemli"
3. Repeat password "Hemli"
3. Klicka på Register

**Output:**

1. Systemet presenterar "Username must have 3 letters and password 6 letters".

### Testfall 1.5 Misslyckad registrering med taggar i Username.
**Input:**

1. Username "<tagg>Svensson</tagg>"
2. Password "Hemligt"
3. Repeat Ppssword "Hemligt"
4. Klicka på Register

**Output:**

1. Systemet presenterar "No valid letters in username".
2. Username innehåller "Svensson"

### Testfall 1.6 Misslyckad registrering med taggar i password.

**Input:**

1. Username "Svensson"
2. Password "<tagg>Hemligt</tagg>"
3. Repeat Password "Hemligt"
4. Klicka på Register

**Output:**

1. Systemet presenterar "Password doesn't match"


### Testfall 1.7 Misslyckad registrering med olika lösenord.

**Input:**

1. Username "Svensson"
2. Password "Hemligt"
3. Repeat password "Hemlighet"
4. Klicka på Register.

**Output:**

1. Systemet presenterar "Password doesn't match".


### Testfall 1.8 Misslyckad Registrering sig med upptaget användarnamn

**Input:**

1. Username "Admin"
2. Password "Password"
3. Repeat password "Password"
4. Klickar på Register.

**Output:**

1. Systemet presenterar "The username is in use. Please try somthing else".

### Testfall 1.9 Misslyckad Registrering med username som finns med stora bokstäver.

**Input:**

1. Username "ADMIN"
2. Password "Password"
3. Repeat password "Password"
4. Klickar på Register.

**Output:**

1. Systemet presenterar "The username is in user. Please try somthing else".

### Testfall 1.10 Lyckad registrering.

**Input:**

1. Username "Svensson"
2. Password "Hemligt"
3. Repeat password "Hemligt"
4. Klickar på Register.

**Output:**

1. Systemet navigerar användaren till loginsidan.
2. Systemet presenterar loginsidan och meddelandet "Success. Your welcome to login now".

### Testfall 1.11 Lyckad registrering och trycker därefter på F5

**Input:**

1. Username "Andersson"
2. Password "Hemligt"
3. Repeat password "Hemligt"
4. Klickar på F5

**OutPut:**

1. Användaren är kvar på loginsidan.
2. Meddelandet visas inte längre.

### Testfall 2.1 Misslyckad inloggning med tomma fält.

**Input:**

1. Klicka på Log in.

**Output:**

1. Systemet presenterar "Username is missing".
2. Ej inloggad

### Testfall 2.2 Misslyckad inloggning med endast giltigt Username.

**Input:**

1. Username "Svensson"
2. Klicka på Log in.

**Output:**

1. Systemet presenterar "Password is missing".
2. Ej inloggad

### Testfall 2.3 Misslyckad inloggning med endast giltigt Password.

**input:**

1. Password "Hemligt"
2. Klicka på Log in

**Output:**

1. Systemet presenterar "Username is missing".
2. Ej inloggad

### Testfall 2.4 Misslyckad inloggning med ogiltigt Username och Password

**Input:**

1. Username "Svenson"
2. Password "Hemlligt"
3. Klickar på Log in

**OutPut:**

1. Systemet presenterar "Username or Password is wrong".
2. Ej inloggad


### Testfall 2.5 Misslyckad inloggning med giltigt Username och ogiltigt Password

**Input:**

1. Username "Svensson"
2. Password "Hemlligt"
3. Klickar på Log in

**Output:**

1. Systemet presenterar "Username or password is wrong".
2. Ej inloggad

### Testfall 2.6 Misslyckad inloggning med taggar i Username och giltigt Password

**Input:**

1. Username "<tagg>Svensson</tagg>"
2. Password "Hemligt"
3. Klicka på Log in

**Output:**

1. Systemet presenterar "Please avoid using taggs".
2. Ej inloggad

### Testfall 2.7 Misslyckad inloggning med taggar i Password
 
 **Input:**

1. Username "Svensson"
2. Password "<tagg>Hemligt</tagg>"
3. Klicka på Log in

**Output:**

1. Systemet presenterar "Username or password is wrong".
2. Ej inloggad

### Testfall 2.8 Inloggning med giltiga värden

**Input:**

1. Username "Svensson"
2. Password "Hemligt"
3. Klicka på Log in

**Output:**

1. Användaren tas till huvudsidan.
2. Inloggad

### Testfall 2.9 Inloggning och bockar i “Remember me”.

**Input:**

1. Username "Svensson"
2. Password "Hemligt"
3. Klicka på Log in

**Output:**

1. Kakor är skapade.
2. Inloggad 

### Testfall 2.10 Posta om utan session

**Input**

1. Logga in.
2. Ta bort sessionen PHPSESSID
3. Ladda om sidan

**Output:**

1. uloggad

### Testfall 2.11 Sessions stöld

**Input:**

1. Logga in på en webläsare
2. Kopiera sessionen
3. Navigera till sidan i en annan webbläsare
4. Klistra in sessionens värde i den nya webbläsaren
5. Ladda om sidan.

**Output:**

1. Systemet presenterar "The session was corrupted and has been deleted".
2. Ej inloggad 

### Testfall 2.12 Inloggad med kakor

**Input:**

1. Logga in (Bocka i Remember me)
2. Ta bort sessionen
3. Ladda om sidan

**Output:**

1. ny session är startad
2. Inloggad

### Testfall 2.13 Manipulerade kakor

**Input:**

1. Logga in (Bocka i Remember me)
2. Ta bort session.
3. Ändra värdet i kakorna
4. Ladda om sidan

**Output:**

1. Systemet presenterar "The cookie was corrupted and has been deleted".
2. Kakorna är borta
3. Utloggad 

### Testfall 2.14 Logga ut

**Input:**

1. Logga in (Bocka i Remember me)
2. Klicka på Log out

**Output:**

1. Sessionen är borta 
2. Kakorna är borta
3. Ej inloggad

### Testfall 3.1 Postar en post

**Input:**

1. Navigera till Home
2. Textbox "Jag är en post"
3. Klicka på Post

**Output:**

1. Posten blir postad.

### Testfall 3.2 Posta en tom post

**Input:**

1. Klicka på Post

**Output:**

1. Systemet presenterar "Please write somthing".
2. Ingen post blev skapad.

### Testfall 3.3 Posta en tom post med bild.

**Input:**

1. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
2. Välj en bild av typen jpg
2. Klicka på Post

**Output:**

1. Systemet presenterar "Please write somthing"
2. Ingen post blev skapad.

### Testfall 3.4 Postar med taggar

**Input:**

1. Textbox "<tagg> testing </tagg>"
2. Klickar på Post

**Output:**

1. Systemet presenterar “Please avoid using taggs”.
2. Ingen post blev skapad


### Testfall 3.5 Postar med whitespace

**Input:**

1. Textbox "       "
2. Klickar på Post

**Output:**

1. Systemet presenterar "Please write somthing".
2. Ingen post blev skapad

### Testfall 3.6 Postar post med bild.

**Input:**

1. Textbox "Jag är en post"
2. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
3. Välj en bild av typen jpg.
4. Klicka på Post

**Output:**

1. Kommentaren blir postad med bilden.


### Testfall 4.1 Delete post

**Input:**

1. Lägg upp en post
2. Klickar på delete knappen i posten.

**Output:**

1. Systemet presenterar “Your post has been deleted”.
2. Både bild och kommentar tas bort.

### Testfall 4.2 Misslyckad delete av andras post

**Input**

1. Lägg upp 2 poster från två olika användare
2. Logga in med den senaste
2. Högerklicka på delete knappen på din senaste post
3. Välj "Inspect element"
4. Hitta den gömda delete knappen
5. Ändra dess value med en siffra mindre tex 90 till 89.
6. Tryck på delete knappen.

**Output:**

1. Ingen post är borttagen

### Testfall 4.3 Delete post i userpage

**Input:**

1. Klicka på användarnamnet på den vänstra sidan
2. Navigera till userpage
3. Klicka på delete knappen i posten

**Output:**

1. Systemet presenterar “Your post has been deleted”.
2. Posten togs bort 

### Testfall 4.4 Misslyckad delete av andras post i userpage

**Input**

1. Lägg upp 2 poster från två olika användare
2. Logga in med den senaste
3. Navigera till userpage
2. Högerklicka på delete knappen på din senaste post
3. Välj "Inspect element"
4. Hitta den gömda delete knappen
5. Ändra dess value till en siffra en annan post har
6. Tryck på delete knappen.

**Output:**

1. Ingen post är borttagen

### Testfall 5.1 Klickar på edit

**Input:**

1. Lägg upp en post
2. Tryck på Edit i posten

**Output:**

1. Popup fönster visas 
2. Textbox med text av den post som skulle ändras.

### Testfall 5.2 Lyckad ändrad kommentar

**Input:**

1. Klicka på Edit knappen i posten
2. Ändra innehållet i textrutan.
3. Klicka på Edit Post

**Output:**

1. Systemet presenterar “Your post has been updated”.
2. Post är ändrad

### Testfall 5.3 Misslyckad edit av andras post

**Input:**

1. Lägg upp 2 poster från två olika användare
2. Logga in med den senaste
3. Klicka på din senaste post
2. Högerklicka på edit knappen i fönstret post
3. Välj "Inspect element"
4. Hitta den gömda edit knappen
5. Ändra dess value med en siffra mindre tex 90 till 89.
6. Tryck på Edit Post knappen

**Output:**

1. Fönstret försvinner
2. Ingen post är ändrad.

### Testfall 5.4 Avbruten edit

**Input:**

1. Trycker på edit i posten.
2. Ändra innehållet i textrutan.
3. Klicka på X knappen.

**Output:**

1. Fönstret försvinner
2. Ingen post är ändrad.

### Testfall 5.5 Misslyckad Post av en bild

**Input:**

1. Textbox "Jag är en post"
2. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
3. Välj en fil som inte är jpg, png eller jpeg.
4. Klicka på Post

**Output:**

1. Systemet presenterar “Invalid file! Please make sure the file is of type png, jpg or jpeg and that the img format is the same as the img type.”
2. Ingen post blev skapad

### Testfall 5.6 fake jpg

**Input:**

1. Ändrar bild namn från test.png till test.jpg
2. Textbox "Jag är en post"
3. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
4. Laddar upp bilden som du ändrade
5. Klicka på post

**Output:**

1. Systemet presenterar “Invalid file! Please make sure the file is of type png, jpg or jpeg and that the img format is the same as the img type.”
2. Ingen post blev skapad

### Testfall 5.7 fake png 

**Input:**

1. Ändrar bild namn från test.jpg till test.png
2. Textbox "Jag är en post"
3. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
4. Laddar upp bilden som du ändrade
5. Klicka på post

**Output:**

1. Systemet presenterar “Invalid file! Please make sure the file is of type png, jpg or jpeg and that the img format is the same as the img type.”
2. Ingen post blev skapad


### Testfall 5.8 Popup fönster i userPage

**Input:**

1. Klicka på edit knappen inne i en post

**Output:**

1. Ett popup fönster visas
2. Textbox med text på den post som skulle ändras.

### Testfall 5.9 Lyckad ändring av post i userpage

**Input:**

1. Klickar på edit knappen i en post
2. Popup rutan visas
3. Ändrar innehållet i textrutan
4. Klickar på Edit Post

**Output:**

1. Systemet presenterar “Your post has been updated”
2. Post är ändrad

### Testfall 5.10 Misslyckad edit av andras post i userPage

**Input:**

1. Lägg upp 2 poster från två olika användare
2. Logga in med den senaste
3. Navigera till userpage
3. Klicka på din senaste posts edit knapp
2. Högerklicka på edit knappen i fönstret post
3. Välj "Inspect element"
4. Hitta den gömda edit knappen
5. Ändra dess value med en siffra mindre tex 90 till 89.
6. Tryck på Edit Post knappen

**Output:**

1. Fönstret försvinner
2. Ingen post är ändrad.

### Testfall 5.11 Avbruten edit i userPage

**Input:**

1. Navigera till userpage
2. Trycker på edit i posten.
3. Ändra innehållet i textrutan.
4. Klicka på X knappen.

**Output:**

1. Fönstret försvinner
2. Ingen post är ändrad.


### Testfall 6.1 Misslyckad ändring av lösenord. Postar med ett blankt fält.

**Input:**

1. Navigera till userpage
2. Tryck på Change Password knappen
3. Popup ruta visas.
4. Klicka på Update.

**Output:**

1. Popup fönstret försvinner
2. Systemet presenterar “Password is missing”.

### Testfall 6.2 Misslyckad ändring av lösenord. Postar med whitespace.

**Input:**

1. Navigera till userpage
2. Tryck på Change Password knappen
3. Popup ruta visas.
4. New Password "       "
4. Klicka på Update.

**Output:**

1. Popup fönstre försvinner
2. Systemet presenterar "Invalid letters in password".

### Testfall 6.3 Misslyckad ändring av lösenord. Postar med taggar.

**Input:**

1. Tryck på Change Password knappen
2. Popup ruta visas
3. New Password "<tagg>Password</tagg>"
4. Klicka på Update

**Output:**

1. Popup rutan försvinner
2. Systemet presenterar "Invalid letters in password"

### Testfall 6.4 Misslyckad ändring av lösenord. För kort lösenord.

**Input:**

1. Tryck på Change Password knappen
2. Popup ruta visas
3. New Password "pass"
4. Klicka på Update

**Output:**

1. popuprutan försvinner
2. Systemet presenterar "At least 6 letters in your password".

### Testfall 6.5 Lyckad ändring ut av lösenord

**Input:**

1. Tryck på Change Password knappen
2. Popup ruta visas
3. New Password "Password"
4. Klicka på Update

Resultat Systemet presenterar "The new password have been saved".

### Testfall 7.1 Lyckad ändring av profilbild

**Input**

1. Navigera till userpage
2. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
3. Välj en fil ut av jpg eller png
4. Klicka på Upload New

**Output:**

1. Systemet presenterar "Your Profile picture has been changed".
2. Profilbilden är ändrad.

### Testfall 7.2 Misslyckad ändring av profilbild. Tomt fält

**Input:**

1. Klicka på Upload New

**Output:**

1. Systemet presenterar "Picture is missing".
2. Profilbilden är oförändrad.

### Testfall 7.3 Misslyckad ändring av profilbild. Ingen bild.

**Input:**

1. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
2. Välj en bild som inte är jpg, png eller jpeg.
3. Klickar på Upload New

**Output:**

1. Systemet presenterar "Invalid file! Please make sure the file is of type png, jpg or jpeg and that the img format is the same as the img type".
2. Profilbilden är oförändrad.

### Testfall 7.4 Misslyckad ändring av profilbild. Fake jpg.

**Input:**

1. Ändrar bild namn från test.png till test.jpg
2. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
3. Laddar upp bilden som du ändrade
4. Klicka på Upload New

**Output:**

1. Systemet presenterar “Invalid file! Please make sure the file is of type png, jpg or jpeg and that the img format is the same as the img type.”
2. Profilbilden är oförändrad.

### Testfall 7.5 Misslyckad ändring av profilbild. Fake png.

**Input:**

1. Ändrar bild namn från test.jpg till test.png
2. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
3. Laddar upp bilden som du ändrade
4. Klicka på Upload New

**Output:**

1. Systemet presenterar “Invalid file! Please make sure the file is of type png, jpg or jpeg and that the img format is the same as the img type.”
2. Profilbilden är oförändrad.

### Testfall 7.6 Misslyckad ändring av profilbild. Större än 3 mb

**Input:**

1. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
2. Laddar upp bild
3. Klicka på Upload New

**Output:**

1. Systemet presenterar "The picture is to big. No more than 3 mb".
2. Profilbilden är oförändrad.

### Testfall 8.1 Navigera till usergallery

**Input:**

1. Klicka på Gallery

**Output:**

1. Systemet presenterar användarens galleri

### Testfall 8.2 Misslyckad uppladding. Tomma fält.

**Input:**

1. Klicka på Upload Picture

**Output:**

1. Systemet presenterar “Picture is missing”.
2. Ingen bild blev postad

### Testfall 8.3 Misslyckad uppladding. Titel ifylt

**Input:**

1. Title "En titel"
2. Klicka på Upload Picture

**Output:**

1. Systemet presenterar “Picture is missing”.
2. Ingen bild blev postad

### Testfall 8.4 Misslyckad uppladdning. Endast bild

**Input:**

1. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
2. Välj en bild av typen jpg, png eller jpeg,
3. Klickar på Upload Picture

**Output:**

1. Systemet presenterar “A title is missing”.
2. Ingen bild blev postad.

### Testfall 8.5 Misslyckad uppladdning. taggar i title.

**Input:**

1.Title "<tagg>en titel </tagg>"
2. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
3. Välj en bild av typen jpg, png eller jpeg,
4. Klicka på Upload Picture

**Output:**

1. Systemet presenterar “Please avoid using taggs in the title input”.
2. Ingen bild blev postad.

### Testfall 8.6 Misslyckad uppladdning. Whitespace i title.

**Input:**

1. Title "   "
2. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
3. Välj en bild av typen jpg, png eller jpeg,
4. Klicka på Upload Picture

**Output:**

1. Systemet presenterar “A title is missing”.
2. Ingen bild blev postad.

### Testfall 8.7 Lyckad uppladdning av bild utan beskrivning

**Input:**

1. Title "Jag är en titel"
2. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
3. Välj en bild av typen jpg, png eller jpeg,
4. Klicka på Upload Picture

**Output:**

1. En ny bild blir uppladdad i gallery.

### Testfall 8.8 Lyckad uppladdning av bild med beskrivning

**Input:**

1. Title "Jag är en titel"
2. Description "Jag är en beskrivning"
2. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
3. Välj en bild av typen jpg, png eller jpeg,
4. Klicka på Upload Picture

**Output:**

1. En ny bild med beskrivning blir uppladdad i gallery.

### Testfall 8.9 Lyckad uppladdning av bild. Whitespace i beskrivning

**Input:**

1. Title "Jag är en titel"
2. Description "     "
2. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
3. Välj en bild av typen jpg, png eller jpeg,
4. Klicka på Upload Picture

**Output:**

1. En ny bild blir uppladdad i gallery.
2. Beskrivning saknas.

### Testfall 8.10 Misslyckad uppladdning av bild. Taggar i description

**Input:**

1. Title "Jag är en titel"
2. Description "<tagg>beskrivning</tagg>"
2. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
3. Välj en bild av typen jpg, png eller jpeg.
4. Klicka på Upload Picture

**Output:**

1. Systemet presenterar “Please avoid using taggs in the description input”.
2. Ingen bild blev postad.

### Testfall 8.11 Misslyckad uppladdning av bild. Ladda upp en txt fil

**Input:**

1. Title "Jag är en titel"
2. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
3. Välj en txt fil
4. Klicka på Upload Picture

**Output:**

1. Systemet presenterar “Invalid file! please make sure the file is of type png, jpg or jpeg and that the img format is the same as the img type”.
2. Ingen bild blev postad.

### Testfall 8.12 Misslyckad uppladdning av bild. Fake jpg

**Input:**

1. Ändrar bild namn från test.png till test.jpg
2. Title "Jag är en titel"
3. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
4. Laddar upp bilden som du ändrade
5. Klicka på Upload Picture

**Output:**

1. Systemet presenterar “Invalid file! Please make sure the file is of type png, jpg or jpeg and that the img format is the same as the img type.”
2. Ingen Bild blev postad

### Testfall 8.13 fake png 

**Input:**

1. Ändrar bild namn från test.jpg till test.png
2. Titel "Jag är en titel"
3. Klicka på (chrome) "Choose file" (firefox) "Browse" knappen
4. Laddar upp bilden som du ändrade
5. Klicka på Upload Picture

**Output:**

1. Systemet presenterar “Invalid file! Please make sure the file is of type png, jpg or jpeg and that the img format is the same as the img type.”
2. Ingen bild blev postad

### Testfall 9.1 Edit gallery popup

**Input:**

1. Ladda upp en bild i galleriet
2. Klicka på Edit under bilden

**Output:**

1. En popup ruta visas med titel och beskrivning i textrutan.

### Testfall 9.2 Edit gallery. Ingen ändring

**Input:**

1. Klicka på edit under bilden.
2. Popup rutan visas.
3. Klicka på Edit Gallery

**Output:**

1. Popuprutan försvinner.
2. Ingen bild blev ändrad.

### Testfall 9.3 Edit gallery.Blanka fält.

**Input:**

1. Klicka på edit under bilden.
2. Popuprutan visas.
3. Töm New Title
4. Töm Description
5. Klicka på Edit Gallery

**Output:**

1. Pipup rutan försvinner
2. Systemet presenterar “A title is missing”.
3. Bilden är oförändrad

### Testfall 9.4 Edit gallery. blankt titel fält och ifylld beskrivning

**Input:**

1. Klicka på edit under bilden.
2. Popuprutan visas.
3. Töm title
4. Klicka på Edit Gallery

**Output:**

1. Popuprutan försvinner
2. Systemet presenterar “A title is missing”
3. Bilden är orändrad

### Testfall 9.5 Edit gallery. Giltig title utan description

**Input:**

1. Klicka på edit under bilden.
2. Popuprutan visas.
3. Töm Description
4. Klicka på Edit Gallery

**Output:**

1. Popuprutan försvinner
2. Systemet presenterar "Your picture's title and description has been updated"
3. Bilden har blank beskrivning.

### Testfall 9.6 Edit gallery. Whitespace i title

**Input:**

1. Klicka på edit under bilden.
2. Popuprutan visas.
3. Title "     "
4. Klicka på Edit Gallery

**Output:**

1. Popuprutan försvinner
2. Systemet presenterar “A title is missing”.
3. Bilden är oförändrad.

### Testfall 9.7 Edit gallery. Taggar i title

**Input:**

1. Klicka på edit under bilden.
2. Popuprutan visas.
3. Title "<tagg>jag är en titel</tagg>"
4. Klicka på Edit Gallery

**Output:**

1. Popuprutan försvinner
2. Systemet presenterar “please avoid using taggs in the title input”.
3. Bilden är oförändrad.

### Testfall 9.8 Edit gallery. Taggar i description

**Input:**

1. Klicka på edit under bilden.
2. Popuprutan visas.
3. Description "<tagg>jag är en beskrivning</tagg>"
4. Klicka på Edit Gallery

**Output:**

1. Popuprutan försvinner
2. Systemet presenterar “please avoid using taggs in the description input”.
3. Bilden är oförändrad.

### Testfall 9.9 Edit gallery. whitespace i description (Description var redan tomt)

**Input:**

1. Klicka på edit under bilden.
2. Popuprutan visas. (Description var redan tomt)
3. Description "   "
4. Klicka på Edit Gallery

**Output:**

1. Popuprutan försvinner
2. Bilden är oförändrad.

### Testfall 9.10 Edit gallery. whitespace i description (Description var redan ifyllt)

**Input:**

1. Klicka på edit under bilden.
2. Popuprutan visas. (Description var redan ifyllt)
3. Description "   "
4. Klicka på Edit Gallery

**Output:**

1. Popuprutan försvinner
2. Systemet presenterar “Your picture’s title and description has been updated”.
3. Bildens beskrivning är blank. 

Trycker på edit kanppen med whitespace i description.(Description var redan ifyllt)
Resultat Systemet presenterar “Your picture’s title and description has been updated”. Bildens beskrivning är blank.
Ändrar den gömnda knappens value till ett existerande och trycker på Edit Gallery.
Resultat Popup rutan försvinner och inget galleri är ändrat.
Trycker på delete nedanför bilden.
Resultat En popupruta visas och undrar om man är riktigt säker.
Trycker på delete nedanför bilden och sen cancle.
Resultat Popup rutan försvinner och inget galleri är borttaget.
Trycker på delete i popup rutan.
Resultat. Systemet presenterar “Your picture has been deleted”. Bilden är borta från galleriet.
Ändrar den gömda knappens value till ett annat existerande i delete popuprutan.
Resultat Popup rutan försvinner och ingen bild har tagits bort.

Kommentera bild - usergallery
Navigera till usergallery och tryck på en bild.
Resultat Bilden och kommentarer presenteras i en stor popupruta.
Postar en kommentar.
Resultat kommentaren blir postad.
Posta en tom kommentar.
Resultat Systemet presenterar "Please write somthing".
Postar med taggar
Resultat Systemet presenterar “Please avoid using taggs”.
Postar med whitespace
Resultat Systemet presenterar "Please write somthing".
Klickar på delete.
Resultat Kommentar tas bort Systemet presenterar “Your comment has been deleted”.
Ändrar den gömda knappens value till ett annat existerande och klickar på Delete
Resultat Ingen kommentar är borttagen.
Klickar på edit.
Resultat Ett popup fönster uppenbarar sig med en textbox med text på den post som skulle ändras.
Klickar på edit, ändrar kommentaren i fönstret och klickar på Edit Post.
Resultat Systemet presenterar “Your komment has been updated”.
Trycker på edit, ändrar den gömda knappens value till ett annat existerande, ändrar posten och klickar på Edit Post.
Resultat Ingen kommentar är ändrad.
Trycker på edit, ändrar innehållet i fältet och klickar på X knappen.
Resultat Fönstret försvinner och posten är inte ändrad.
Admin tar bort någon annans kommentar.
Resultat Kommentar tas bort. Systemet presenterar “Your comment has been deleted”.
Admin uppdaterar någon annans post.
Resultat Systemet presenterar “Your comment has been updated”. Kommentaren uppdateras.
Laddar upp en fil som inte är jpg, png eller jpeg och en post.
Resultat Systemet presenterar “Invalid file! Please make sure the file is of type png, jpg or jpeg and that the img format is the same as the img type.” Ingen post blev skapad
Laddar upp en och ändrar bild namn från test.png till test.jpg och en post.
Resultat Systemet presenterar “Invalid file! Please make sure the file is of type png, jpg or jpeg and that the img format is the same as the img type.” Ingen post blev skapad.
Laddar upp en och ändrar bild namn från test.jpg till test.png och en post.
Resultat Systemet presenterar “Invalid file! Please make sure the file is of type png, jpg or jpeg and that the img format is the same as the img type.” Ingen post blev skapad.
Laddar upp en bild som är större än 3 mb
Resultat Systemet presenterar “The picture is to big. No more than 3 mb!”
Laddar upp en post och trycker sedan på F5.
Resultat Ingen duplisering ut av kommentaren.


Admin ändrar, tar bort medlem - memberPage
Trycker på Update med ett blankt fält.
Resultat Systemet presenterar “Password is missing”.
Trycker på Update med whitespace.
Resultat Systemet presenterar "Invalid letters in password".
Trycker på Update med taggar.
Resultat Systemet presenterar "Invalid letters in password"
Trycker på Update med 5 eller minre bokstäver.
Result Systemet presenterar "At least 6 letters in your password".
Trycker på Update med giltiga värden.
Resultat Systemet presenterar "The new password have been saved".

Trycker på delete hos en medlem.
Resultat En popup rutan uppenbarar sig och frågar om man är riktigt säker.

I delete popuprutan trycker admin på cancel.

Resultat . Popuprutan försvinner och ingen medlem är borta.
I delete popuprutan trycker admin på Delete.

Resultat  Systemet presenterar “The member has been deleted”. Popuprutan försvinner och ingen medlem är borta.

URL - Test 
 Navigera till sidan. “latana.se/PHP/myFace/”
Resultat  Loginsidan visas. 
 Navigera till login-sidan. “latana.se/PHP/myFace/index.php”
Resultat  Loginsidan visas.
Navigera till login-sidan “latana.se/PHP/testing/index.php?login”
Resultat  Loginsidan visas.
 Navigera till “latana.se/PHP/myFace/” med cookies aktiva. 
Resultat  frontpage visas.
 Navigera till “latana.se/PHP/myFace/index.php” med cookies aktiva.
Resultat  frontpage visas.
 Navigera till “latana.se/PHP/myFace/?userPage” med cookies aktiva.
Resultat  userPage visas.
 Navigera till “latana.se/PHP/myFace/?memberPage” med cookies aktiva.
Resultat  memberPage visas.
 Navigera till “latana.se/PHP/myFace/?usergallery” med cookies aktiva.
Resultat  userPage visas.
 Navigera till “latana.se/PHP/myFace/?usergallery=userthatexist” med cookies aktiva.
Resultat  usergallery visas.
 Navigera till “latana.se/PHP/myFace/?usergallery=userdontexist” med cookies aktiva.
Resultat  usergallery visas med texten “The selected user could not be found!”

 Navigera till “latana.se/PHP/myFace/?usergalleryusername” med cookies aktiva.
Resultat  frontpage visas.

 Navigera till “latana.se/PHP/myFace/?usergallery=userdontexist&gallery=5” med cookies aktiva.
Resultat  usergallery visas med texten “The selected user could not be found!”

 Navigera till “latana.se/PHP/myFace/?usergallery=userexist&gallery=5” med cookies aktiva. Numret existerar inte.
Resultat  usergallery visas med texten “The selected img could not be found!”

 Navigera till “latana.se/PHP/myFace/?usergallery=userexist&gallery=abc” med cookies aktiva. Numret existerar inte.
Resultat  usergallery visas med texten “The selected img could not be found!”

 Navigera till “latana.se/PHP/myFace/?usergallery=userexist=abc” med cookies aktiva.
Resultat  usergallery visas.

 Navigera till “latana.se/PHP/myFace/?usergallery” med cookies aktiva.
Resultat  usergallery visas med texten “The selected user could not be found!”.


 Navigera till “latana.se/PHP/myFace/?usergallery” ingen session eller cookies.
Resultat  Loginsidan visas.

 Navigera till “latana.se/PHP/myFace/?wrongsite” ingen session eller cookies.
Resultat  errorsidan visas med meddelandet “The page cannot be found or an unexpected error has accerd. Please click on the home link and try again”.

 Navigera till “latana.se/PHP/myFace/index.php?wrongsite” ingen session eller cookies.
Resultat  frontPage visas.

!!!ADMIN!!!

Admin tar bort någon annans post.
Resultat Post tas bort. Systemet presenterar “Your post has been deleted”.
Admin uppdaterar någon annans post.
Resultat Kommentaren uppdateras.

