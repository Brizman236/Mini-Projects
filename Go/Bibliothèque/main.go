package main

import (
    "fmt"
    "github.com/fatih/color"
    "github.com/olekukonko/tablewriter"
    "os"
    "bufio"
    "strings"
)

type Livre struct {
    Titre      string
    Auteur     string
    Disponible bool
}

func main() {
    librairie := make(map[string]*Livre)

    librairie["Les Misérables"] = &Livre{"Les Misérables", "Victor Hugo", true}
    librairie["L'Etranger"] = &Livre{"L'Etranger", "Albert Camus", true}
    librairie["Comment se faire des amis"] = &Livre{"Comment se faire des amis", "Dale Carnegie", true}

    console(librairie)
}

func console(librairie map[string]*Livre){
    for ; ; {
        displayBook(librairie)

        fmt.Println("========= Console =========")
        fmt.Print("1. Afficher les livres\n2. Ajouter un livre\n3. Emprunter un livre\n4. Rendre un livre\n0. Quitter\n\n[+] Votre choix : ")
        reader := bufio.NewReader(os.Stdin)
        choice, _ := reader.ReadString('\n')
        choice = strings.TrimSpace(choice)

        switch choice {
        case "1":
            displayBook(librairie)
        case "2":
            addBook(librairie)
        case "3":
            borrowBook(librairie)
        case "4":
            returnBook(librairie)
        case "0":
            fmt.Print("Bye !")
            return
        default :
            rouge := color.New(color.FgRed)
            rouge.Println("[+] Cette option n'est pas disponible ")
        }
    }
}
func addBook(librairie map[string]*Livre) {
    reader := bufio.NewReader(os.Stdin)
    fmt.Print("[+] Veuillez entrer le titre du livre : ")
    titre, _ := reader.ReadString('\n')
    titre = strings.TrimSpace(titre)
    fmt.Print("[+] Veuillez entrer le nom de l'auteur : ")
    auteur, _ := reader.ReadString('\n')
    auteur = strings.TrimSpace(auteur)

    librairie[titre] = &Livre{Titre: titre, Auteur: auteur, Disponible: true}

    fmt.Println("\n\n")
}

func displayBook(librairie map[string]*Livre) {
    table := tablewriter.NewWriter(os.Stdout)
    table.SetHeader([]string{"Titre", "Auteur", "Disponible"})

    table.SetBorder(false)
    table.SetRowLine(false)

    fmt.Println("\nTous les livres :\n")
    for _, livre := range librairie {
        if livre.Disponible {
            table.Rich(
                []string{livre.Titre, livre.Auteur, "Oui"},
                []tablewriter.Colors{
                    {tablewriter.FgWhiteColor},
                    {tablewriter.FgWhiteColor},
                    {tablewriter.FgWhiteColor, tablewriter.FgHiGreenColor},
                },
            )
        } else {
            table.Rich(
                []string{livre.Titre, livre.Auteur, "Non"},
                []tablewriter.Colors{
                    {tablewriter.FgWhiteColor},
                    {tablewriter.FgWhiteColor},
                    {tablewriter.FgWhiteColor, tablewriter.FgHiRedColor},
                },
        )
        }
    }
    table.Render()
    fmt.Println("\n\n")
}

func borrowBook(librairie map[string]*Livre) {
    rouge := color.New(color.FgRed)
    vertGras := color.New(color.FgGreen, color.Bold)
    jaune := color.New(color.FgYellow)

    displayBook(librairie)
    fmt.Print("[+] Veuillez entrer le titre du livre à emprunter : ")
    reader := bufio.NewReader(os.Stdin)
    titre, _ := reader.ReadString('\n')
    titre = strings.TrimSpace(titre)

    livre, ok := librairie[titre]
    if !ok {
        rouge.Println("[+] Le livre n'existe pas")
        return
    }

    if livre.Disponible {
        vertGras.Println("[+] Le livre", titre, "a été emprunté avec succès !")
        switchAvailable(librairie, titre)
    } else {
        jaune.Println("[+] Le livre", titre, "n'est pas disponible")
    }
    fmt.Println("\n\n")
}

func returnBook(librairie map[string]*Livre){

    jaune := color.New(color.FgYellow)
    rouge := color.New(color.FgRed)
    vertGras := color.New(color.FgGreen, color.Bold)

    fmt.Print("[+] Quel livre voulez-vous retourner : ")
    reader := bufio.NewReader(os.Stdin)
    titre, _ := reader.ReadString('\n')
    titre = strings.TrimSpace(titre)
    var isExist = false
    for title, livre := range librairie {
        if title == titre && !livre.Disponible {
            switchAvailable(librairie, title)
            isExist = true
            vertGras.Println("[+] ", titre, " est rendu avec succès !")
            return
        }
        if title == titre && livre.Disponible {
            jaune.Println("[+] ", titre, " n'a pas été emprunté ")
            return
        }
    }

    if !isExist {
        rouge.Println("[+] ", titre, " n'a jamais été dans cette bibliothèque ")
    }
}

func switchAvailable(librairie map[string]*Livre, title string) {
    if livre, ok := librairie[title]; ok {
        livre.Disponible = !livre.Disponible
    }
}
