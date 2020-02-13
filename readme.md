

## Angola Phone Numbers Api

APNA is an Angolan API created to help developers obtain information such as which operator, to whom it belongs and which ticket number a phone number is associated with for validations at the time of registration.


## What can you do with APNA?

Receive information from an Angolan phone number before registering on your system, compare it to the data entered or simply save your user's time by completing the fields with information from our API.

[Click here to see this example with the phone number of one of our developers](https://angola-pna.herokuapp.com/api/get-info/244927562797)

The existing phone numbers at APNA are entered manually on the [APNA website](https://angola-pna.herokuapp.com/). APNA's objective is to grow and consume data directly from Angolan operators such as Unitel, Movicel, Angola Telecom and Tv Cabo, in order to provide information associated with a telephone number to public and private institutions, in order to assist in verification, time saving and better user experience.

### Available information associated with a phone number


| Variable       | Value  | Exemple    | Description   |
| ---            | ---    | ---        | ---           |
| name           | Full name  |Ravelino de Castro| Requireed field in the registration process on the website and itul for organizations in which they plan to join the API |
| bi  | ID card number| 004758993LA045  | Optional field, it is one of the allowed document used to register a phone number |
| nif  | Taxpayer number | 004758993LA045 | Optional field, it is one of the allowed document used to register a phone number |
| passport  | Passport number | N2044977| Optional field, it is one of the allowed document used to register a phone number |
| residence_card  | Residence card | xxx-xx-xx   |Optional field, it is one of the allowed document used to register a phone number |
| email  | E-mail | ravelinodecastro@gmail.com  | This info can be updated |
| operator  | Operator | Tv Cabo  | It's an object which contains the name of operator and the type, if it is mobile or fixed  |
| status  | Status | 1 for for active and 0 for disable  | This inform if the number is being used or blocked |
| address  | Address | Luanda, Av. 21 de Janeiro - Morro Bento  | This info can be updated  |
| gender  | Gender | 0 for male, 1 for female and 2 for companies or organizations  | This is a very important field |
| birth_date  | Birthday | 03-05-1999  | Also another important field  |

## Contributing

You can always contribute for the improvment of this project, send an email to join this project.

## Donation

If you think is project can be usefull, donate to mativate the team on keep working on it. [Click here to donate](https://angola-pna.herokuapp.com/#donation-section)


