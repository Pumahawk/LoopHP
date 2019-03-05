# LoopHP
Libreria general purpose per la creazione e configurazione di applicazioni web utilizzando il pattern MVC.

LoopHP e' stato creato utilizzando i componenti principali di Symfony e grazie alla sua facile configurazione e' possibile
creare nuove applicazioni web oppure estendere applicazioni gia esistenti migliorandone la portabilita'.

---

# Utilizzo

Configurare LoopHP e' molto semplice, anche se a prima vista puo sembrare complicato, ricordiamo che e' una applicazione general
purpose e questo gli permette di adattarsi a diversi contesti.

Le componenti princiapli di questa libreria sono:
* App
* AppConfiguration
* Matchable

Tutte le precedenti componenti devono essere istanziate nella maniera opportuna per poter funzionare.

## Descrizione componenti

### App

Classe che rappresenta l'origine dell'applicazione. Se configurata nella maniera corretta permette di utilizzare il pattern MVC
per richiamare dei metodi decisi in fase di configurazione.

### AppConfiguration

Classe utile ad una semplice configurazione dell'applicazione. In questa fase vengono segnati i percorsi delle cartelle contenenti
i file di configurazione, i template, eventuali librerie aggiuntive.

### Matchable

Interfaccia necessaria all'applicazione per decidere in base ad un determinato contesto quale metodo di un determinato controller
richiamare.  
Nella libreria sono presenti delle classi che implementano questa interfaccia per agevolare la creazione di applicazioni web
complesse.

# Funzionalita aggiuntive

Nonostante l'obbiettivo di LoopHP e' quello di essere piu generica ed estendibile possibile, viene fornita con una serie di 
funzionalita specifiche utili alla creazione di applicazioni seguendo uno standard e permettendo una portabilita' di contenuti
creati da terzi ed eseguibili da qualunque piattaforma che utilizza LoopHP.

Per la realizzazione di queste funzionalita sono stati utilizzati diversi componenti di Symfony, i quali sono stati indisponsabili
per la realizzazione di LoopHP.

Le principali funzionalita presenti nella libreria sono:
* Gestore di file di configurazione in PHP
* Template engine in PHP
* Libreria di Routing

# Esempi e documentazione

Ogni classe presente nella cartella src e' fornita di una descrizione ed e' possibile utilizzare lo strumento phpDocumentor per
la generazione automatica di una documentazione.  
Inoltre, nella cartella test sono presenti numerosi test sulle funzionalita della libreria e numerosi esempi sulla creazione di
diversi tipi di applicazioni utilizzando metodi piu' o meno complessi.
