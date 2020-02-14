

## Angola Phone Numbers Api

APNA is an Angolan API created to help developers to obtain information associated with a phone number such as their full name, date of birth, address, ID card number, the operator in order to save users' time and prevent the insertion of wrong or false data during registration.


## What can you do with APNA?

Receive information from an Angolan phone numbers before registering on your system, compare it to the data entered or simply save your user's time by completing the fields with information from our API avoid users to insert fake datas.

[Click here to see this example with the phone number of one of our developers](https://angola-pna.herokuapp.com/api/get-info/244927562797)

The existing phone numbers at APNA are entered manually on the [APNA website](https://angola-pna.herokuapp.com/). APNA's objective is to grow and consume data directly from Angolan operators such as Unitel, Movicel, Angola Telecom and Tv Cabo, in order to provide information associated with a phone number to public or private institutions, in order to help them getting their users information or save their users's time and giving a better experience.

---
## Testing insertion of data

This functionality is available on the landing page and it will last as long as APNA does not have a source to feed data from operators. To enter the information, you must fill in all the required fields, fill in correctly, as there is a validation, specifically in the format of the telephone number, identity card number, taxpayer card, passport number or residence card (Portugal model).

You can associate two phone numbers with the same customer, just enter the same data as in the previous registration and change only the phone number. You can update your email or address, inserting the same data in one of the registrations and changing only the desired fields, you can likewise add the passport number, taxpayer card, residence card, repeating the registration process, changing just the type and number of the document.

---

## Usage (Javascript)

```javascript
let phone = '244927562797';
fetch(`https://angola-pna.herokuapp.com/api/get-info/${phone}`, {
        method: 'get',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ 
           "client_id": "xxx", //not requied yet
           "secret": "xxx" //not requied yet
        })

    }).then((response) => response.json())
        .then((res) => {
            console.log(res)
        }).catch((error) => {
            console.error(error)
    });
```

---

## Usage (Php)

```php
$phone = '244927562797';
$url ='https://angola-pna.herokuapp.com/api/get-info/'.$phone;
$id= "xxx"; //not requied yet
$secret="xxx"; //not requied yet
$fields = '?client_id='.$id.'&secret='.$secret.'' ;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url.$fields);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 3);
$response = trim(curl_exec($ch));
curl_close($ch);

echo $response;
```

---
## Usage (Python)

```python
phone = '244927562797'
key= 'xxx' #not requied yet
secret= 'xxx' #not requied yet
response = requests.get('https://angola-pna.herokuapp.com/api/get-info/${phone}?client_id=${key}&secret=${secret}')
print(response)
```

---
## Usage (Dart)

```dart
import 'package:http/http.dart' as http;
String phone = '244927562797';
String id= "xxx"; //not requied yet
String secret="xxx"; //not requied yet
Future<http.Response> fetchPhone() {
  return http.get('https://angola-pna.herokuapp.com/api/get-info/${phone}?client_id=${id}&secret=${secret}');
}
```

---
## Usage (Go)

```Go
import (
  "fmt"
  "net/http"
  "io/ioutil"
)

func Fetch() {
  phoneNumber := "244948088007"
  client := "xxx"
  secret := "xxx"
  url := fmt.Sprintf("https://angola-pna.herokuapp.com/api/get-info/%d?client_id=%s&secret=%s", phoneNumber, client, secret)

  client := &http.Client {}
  req, err := http.NewRequest("GET", url, nil)

  if err != nil {
    fmt.Println(err)
  }
  res, err := client.Do(req)
  defer res.Body.Close()
  body, err := ioutil.ReadAll(res.Body)

  fmt.Println(string(body))
}
```

---

### Available information associated with a phone number


| Variable       | Value  | Exemple    | Description   |
| ---            | ---    | ---        | ---           |
| name           | Full name  |Ravelino de Castro| Requireed field in the registration process on the website and itul for organizations in which they plan to join the API |
| bi  | ID card number| 004758993LA045  | Optional field, it is one of the allowed document used to register a phone number |
| nif  | Taxpayer number | 004758993LA045 | Optional field, it is one of the allowed document used to register a phone number |
| passport  | Passport number | N2044977| Optional field, it is one of the allowed document used to register a phone number |
| residence_card  | Residence card | A2N65899   |Optional field, it is one of the allowed document used to register a phone number |
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


