#include <stdlib.h>
#include <stdio.h>
#include "calculator.h"

int main (int argc,char *argv[]){
    
    char operation;
    double numb1 ;
    double numb2;
    double result;
    char *op_pointer = &operation;
    double *numb1_pointer = &numb1;
    double *numb2_pointer = &numb2;
    double *result_pointer;
    
    printf("Entrer l'operateur entre ' +, -, /, * ' : ");
    scanf("%c", op_pointer);

    // Controle de saisie
    while (operation != '+' && operation != '/' && operation != '*' && operation != '/' && operation != '-') {
        printf("L'operateur doit etre parmi ceux-ci :  ' +, -, /, *'. Retry... ");
        scanf(" %c", op_pointer);
    }

    // Demandons maintenant a l'utilisateur les 2 operandes
    printf("Enter the fisrt number : ");
    scanf("%lf", numb1_pointer);
    printf("Enter the second number : ");
    scanf("%lf", numb2_pointer);

    // Et maintenant verifions chaque cas

    switch (operation)
    {
    case '+':
        result = addition(numb1, numb2);
        break;
    
    case '*':
        result = multiplication(numb1, numb2);
        break;

    case '-':
        result = subtraction(numb1, numb2);
        break;
    
    case '/':
        result = division(numb1, numb2);
        break;

    default:
        break;
    }

    printf("Result : %lf \n \n", result);

    return 0;
}

// The sum function
double addition(double numb1, double numb2){
    double sum = numb1 + numb2;
    return sum;
}

// The subtraction function
double subtraction(double numb1, double numb2){
    double sum = numb1 - numb2;
    return sum;
}

// The multiplication function
double multiplication(double numb1, double numb2){
    double sum = numb1 * numb2;
    return sum;
}

// The division function
double division(double numb1, double numb2){
    double sum = numb1 / numb2;
    return sum;
}
