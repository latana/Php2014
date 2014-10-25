# Review Rapport

###Översikt
Jag var nöjd med koden till en början, men med tiden som projektet växte så så blev det svårt för mig att fokusera på en sak i taget. När jag återkom till kod som jag inte tittat på på länge blev jag väldigt förvirrad. Det är svårt att förutse vad man förstår och inte förstår i framtiden men det var inget lite kommentarer inte kunde lösa.
Trots mina tappra kommentarer så hade jag grovt underskattat tiden det skulle ta att underhålla ett sådant projekt.

Jag är inte riktigt nöjd med min refactoring. Jag kunde aldrig bli av med mina funktioner i varje dal klass som använder sig ut av klassen imgpreparer.

Jag är inte heller nöjd med hur min postView frågar sig själv om användaren gör en post,  hämtar och jämnför ett id från den posten. Men jag ville att postens ruta skulle förvandlas och inte bara läggas till. I framtiden tror jag nog att jag struntar i sådant så länge det är server baserat.

Jag anser att jag misslyckades lite med min struktur mellan mina views och masterview. Tanken var att alla skulle ärva från den men det blev lite strul sen när controllerna kommunicerade med varandra.

Mina tester går igenom vilket gör mig paranoid om det verkligen är bra tester. Det är första gången jag testar på denna storleken och det har varit svårt att få ihop tiden. Men för övrigt har jag inte hittat några buggar vilket gör mig lite rädd.

Alla mina "Popup fönster" gör jag på lite olika vis. Det är dels för att jag inte hittade något bra sätt för controllern och viewn att hantera popup fönster. Det funkar väl men enligt mig så är det inte det snyggaste.

I min postDAL har hand om att ta bort en användare och allting relaterat till denna användare. Jag vill att varje DAL klass ska ha hand om var sin tabell och det finns andra sätt jag kunde gjort men ingen som jag kände var tillräckligt bra.

