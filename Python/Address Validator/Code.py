def mailValid(mail: str):
    listEmail = list(mail)
    isValid = False
    for i in range(len(listEmail)):
        if listEmail[i] == '@' and i != 0:
            for j in range(i, len(listEmail)):
                if listEmail[j] == '.':
                    isValid = True

    return isValid

mail = input("[+] Entrer votre adresse mail : ")

if mailValid(mail):
    print('\n\n[+] Adresse valide')
else:
    print('\n\n[+] Adresse invalide')
   



