package main

import (
	"fmt"
	"github.com/fatih/color"
	"encoding/json"
	"github.com/olekukonko/tablewriter"
	"os"
	"bufio"
	"strings"
	"strconv"
)


// Variables Globales
var input = bufio.NewReader(os.Stdin)
var rouge = color.New(color.FgHiRed)
var vert = color.New(color.FgGreen)
var jaune = color.New(color.FgHiYellow)
var reader *Reader


type Livre struct {
	Id int `json:"id"`
	Titre string `json:"titre"`
	Auteur string `json:"auteur"`
	Annee int `json:"year"`
	Genre string `json:"genre"`
	Disponible bool `json:"disp"`
}

type Reader struct {
	Id int `json:"id"`
	Nom string `json:"nom"`
	Emprunt []int `json:"emprunt"`
}

func main(){
	var choix string
	fmt.Print("\033[H\033[2J")
	fmt.Println("Bienvenu cher lecteur, je m'appelle Lucinda, à votre service !")
	fmt.Print("Etes vous enregistré dans notre bibliothèque ? (Oui/Non) ")
	fmt.Scanln(&choix)

	for ; ; {
		if choix != "Oui" && choix != "Non" {
			fmt.Print("Veuillez répondre par 'Oui' ou 'Non' : ")
			fmt.Scanln(&choix)
		} else { 	
			break
		}
	}
	switch choix {
		case "Non":
			fmt.Println("D'accord, nous allons procéder à votre enregistrement alors.")
			register()
		case "Oui":
			login()
	}

		console(reader)
}

func console(lecteur *Reader) {
	for ; ; {
		fmt.Print("\033[H\033[2J")
		fmt.Println("-------- Console --------")
		fmt.Print("1. Afficher tous les livres\n2. Afficher les livre empruntés\n3. AJouter un livre\n4. Emprunter un livre\n5. Rendre un livre\n6. Changer d'utilisateur\n0. Quitter\n[+] Votre choix : ")
		choix,_ := input.ReadString('\n')
		choix = strings.TrimSpace(choix)
		switch choix {
			case "1":
				displayBook()
				input.ReadString('\n')
			case "2":
				displayBorrowedBooks(lecteur)
			case "3":
				addBook()
			case "4":
				borrowBook(lecteur)
			case "5":
				returnBook(lecteur)
			case "6":
				login()
			case "0":
				return
			default :
				rouge.Print("Cette option n'est pas disponible. Appuyer sur ENTRER ")
				input.ReadString('\n')
		}
	}
}


func nextUserId(readers []Reader) int{
	return len(readers) + 1
}

func nextBookId(books []Livre) int {
	return len(books) + 1
}

func register(){
	var emprunt []int
	readers, _ := getReaders()

	fmt.Print("[+] Veuiller nous donner votre nom : ")
	nom, _ := input.ReadString('\n')
	nom = strings.TrimSpace(nom)
	id := nextUserId(readers)
	newReader := Reader{Id: id, Nom: nom, Emprunt: emprunt}

	readers = append(readers, newReader)
	writeReaderFile(readers)
	reader = &newReader
}

func login() {
	var nom string
	isExist := false
	fmt.Print("[+] Veuillez entrer votre nom : ")
	nom, _ = input.ReadString('\n')
	nom = strings.TrimSpace(nom)

	readers, _ := getReaders()

	for i, reader1 := range readers {
		if nom == reader1.Nom {
			isExist = true
			reader = &readers[i]
			vert.Print("[+] Utilisateur ", nom, " connecté avec succès ! Appuyer sur ENTRER ")
			input.ReadString('\n')
		}
	}

	if !isExist {
		rouge.Println("[+] Vous n'êtes pas enregistré dans cette bibliothèque. Appuyer sur ENTRER ")
		main()
	}
	
}

func getBooks() ([]Livre, *os.File){
	var books []Livre

	file, err := os.Open("livres.json")
    if err != nil {
        panic(err)
    }
    defer file.Close()

	// Lecture du fichier
    decoder := json.NewDecoder(file)
    err = decoder.Decode(&books)
    if err != nil {
        panic(err)
    }

	return books, file
}

func getReaders() ([]Reader, *os.File){
	var readers []Reader
	file, err := os.Open("users.json")
    if err != nil {
        panic(err)
    }
    defer file.Close()

	// Lecture du fichier
    decoder := json.NewDecoder(file)
    err = decoder.Decode(&readers)
    if err != nil {
        panic(err)
    }

	

	return readers, file
}

func writeReaderFile(readers []Reader){
	file, err := os.OpenFile("users.json", os.O_WRONLY|os.O_TRUNC, 0644)
    if err != nil {
        panic(err)
    }

	defer file.Close()

	encoder := json.NewEncoder(file)
	encoder.SetIndent("", "  ") // format lisible
	encoder.Encode(readers)
}

func addBook(){
	var newBook Livre
	books, _ := getBooks()

	fmt.Print("\033[H\033[2J")
	fmt.Print("[+] Entrer le titre du livre : ")
	titre, _ := input.ReadString('\n')
	titre = strings.TrimSpace(titre)

	fmt.Print("[+] Entrer le nom de son auteur : ")
	auteur, _ := input.ReadString('\n')
	auteur = strings.TrimSpace(auteur)

	fmt.Print("[+] Entrer l'année : ")
	annee, _ := input.ReadString('\n')
	annee = strings.TrimSpace(annee)
	year, err := strconv.Atoi(annee)

    for ;err != nil; {
        rouge.Println("[+] Valeur invalide ")
        fmt.Print("[+] Entrer l'année : ")
		annee, _ := input.ReadString('\n')
		annee = strings.TrimSpace(annee)
		year, err = strconv.Atoi(annee)
    }
	fmt.Print("[+] Entrer son genre : ")
	genre, _ := input.ReadString('\n')
	genre = strings.TrimSpace(genre)

	newBook = Livre{Id : nextBookId(books), Titre: titre, Auteur: auteur, Annee: year, Genre: genre, Disponible: true }
	books = append(books, newBook)
	writeBookFile(books)

	vert.Print("[+] ", titre, " a été ajouté avec succès ! Appuyer sur ENTRER ")
	input.ReadString('\n')
}

func writeBookFile(books []Livre){

	file, err := os.OpenFile("livres.json", os.O_WRONLY|os.O_TRUNC, 0644)
    if err != nil {
        panic(err)
    }

	defer file.Close()

	encoder := json.NewEncoder(file)
	encoder.SetIndent("", "  ") // format lisible
	encoder.Encode(books)
}

func displayBook(){
	fmt.Print("\033[H\033[2J")
	books, _ := getBooks()

    table := tablewriter.NewWriter(os.Stdout)
    table.SetHeader([]string{"Id", "Titre", "Auteur", "Année", "Genre", "Disponibile"})

    table.SetBorder(false)
    table.SetRowLine(false)

    fmt.Println("\nTous les livres :\n")
    for _, livre := range books {
        if livre.Disponible {
            table.Rich(
                []string{strconv.Itoa(livre.Id), livre.Titre, livre.Auteur, strconv.Itoa(livre.Annee), livre.Genre, "Oui"},
                []tablewriter.Colors{
                    {tablewriter.FgWhiteColor},
                    {tablewriter.FgWhiteColor},
                    {tablewriter.FgWhiteColor},
                    {tablewriter.FgWhiteColor},
                    {tablewriter.FgWhiteColor},
                    {tablewriter.FgWhiteColor, tablewriter.FgHiGreenColor},
                },
            )
        } else {
            table.Rich(
                []string{strconv.Itoa(livre.Id), livre.Titre, livre.Auteur, strconv.Itoa(livre.Annee), livre.Genre, "Non"},
                []tablewriter.Colors{
                    {tablewriter.FgWhiteColor},
                    {tablewriter.FgWhiteColor},
                    {tablewriter.FgWhiteColor},
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

func borrowBook(reader *Reader){
	
	books, _ := getBooks()
	readers, _ := getReaders()
	isExist := false

	if len(reader.Emprunt) == 3 {
		jaune.Println("Vous aviez atteint la limite des 3 livres empruntés. Appuyer sur ENTRER ")
		input.ReadString('\n')
	} else {
		displayBook()
		
		fmt.Print("[+] Entrez l'ID du livre à emprunter : ")
		ID, _ := input.ReadString('\n')
		ID = strings.TrimSpace(ID)
		id, err := strconv.Atoi(ID)

		for ;err != nil; {
			rouge.Println("[+] Valeur invalide ")
			fmt.Print("[+] Entrer l'ID : ")
			ID, _ = input.ReadString('\n')
			ID = strings.TrimSpace(ID)
			id, err = strconv.Atoi(ID)
    	}

		for _, book := range books {
			if book.Id == id {
				isExist = true
				if book.Disponible {
					book.Disponible = false
					vert.Print("[+] ", book.Titre, " a été emprunté avec succès ! Appuyer sur ENTRER ")
					reader.Emprunt = append(reader.Emprunt, book.Id)
					setBook(books, book)
					setReader(readers)
					input.ReadString('\n')
				} else {
					jaune.Print("[+] ", book.Titre, " n'est pas disponible ! Appuyer sur ENTRER ")
					input.ReadString('\n')
				}
			}
		}

		if !isExist {
			rouge.Print("Un livre avec l'ID", ID, " ne figure pas dans notre bibiothèque ! Appuyer sur ENTRER ")
			input.ReadString('\n')
		}
		
		
	}
}

func displayBorrowedBooks(reader *Reader) {
	if len(reader.Emprunt) == 0 {
		jaune.Println("Aucun livre n'a été emprunté. Appuyer sur ENTRER ")
		input.ReadString('\n')	
	} else {
		fmt.Print("\033[H\033[2J")
		books, _ := getBooks()
		table := tablewriter.NewWriter(os.Stdout)
		table.SetHeader([]string{"Id", "Titre", "Auteur", "Année", "Genre"})
	
		table.SetBorder(false)
		table.SetRowLine(false)
	
		for _, id := range reader.Emprunt {
			for _, book := range books {
				if id == book.Id {
					table.Rich(
						[]string{strconv.Itoa(book.Id), book.Titre, book.Auteur, strconv.Itoa(book.Annee), book.Genre},
						[]tablewriter.Colors{
							{tablewriter.FgWhiteColor},
							{tablewriter.FgWhiteColor},
							{tablewriter.FgWhiteColor},
							{tablewriter.FgWhiteColor},
							{tablewriter.FgWhiteColor},
						},
				)
			}
			}
		}
		table.Render()
		input.ReadString('\n')
	}
}

func returnBook(reader *Reader){
	fmt.Print("\033[H\033[2J")
	if len(reader.Emprunt) == 0 {
		jaune.Println("Aucun livre n'a été emprunté. Appuyer sur ENTRER ")
		input.ReadString('\n')
	} else {
		displayBorrowedBooks(reader)
		books, _ := getBooks()
		readers, _ := getReaders()
		fmt.Print("[+] Entrez l'ID du livre à rendre : ")
		id, _ := input.ReadString('\n')
		ID, err := strconv.Atoi(id)

    	for ;err != nil; {
			rouge.Println("[+] Valeur invalide ")
			fmt.Print("[+] Entrer l'ID : ")
			id, _ = input.ReadString('\n')
			id = strings.TrimSpace(id)
			ID, err = strconv.Atoi(id)
    	}
		
		for index, i := range reader.Emprunt{
			if i == ID {
				reader.Emprunt = append(reader.Emprunt[:index], reader.Emprunt[index+1:]...)
				for _, book := range books {
					if book.Id == ID {
						book.Disponible = true
						vert.Print("[+] ", book.Titre, " a été rendu avec succès ! Appuyer sur ENTRER ")
						input.ReadString('\n')
					}

				setBook(books, book)
				setReader(readers)
				}
			}
		}

	}
}

func setReader(readers []Reader) {
	for i, eachReader := range readers {
		if eachReader.Nom == reader.Nom {
			readers[i] = *reader
			writeReaderFile(readers)
		}
	}
}

func setBook(books []Livre, book Livre) {
	for i, eachBook := range books {
		if eachBook.Id == book.Id {
			books[i] = book
			writeBookFile(books)
		}
	}
}
