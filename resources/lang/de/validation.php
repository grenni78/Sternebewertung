<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
     */

    'accepted' => 'Das Feld :attribute muss akzeptiert werden.',
    'active_url' => 'Das Feld :attribute enthält keine gültige URL.',
    'after' => 'Das Feld :attribute muss ein Datum nach :date enthalten.',
    'after_or_equal' => 'Das Feld :attribute muss ein Datum größer oder gleich :date enhalten.',
    'alpha' => 'Das Feld :attribute darf nur Buchstaben enthalten.',
    'alpha_dash' => 'Das Feld :attribute darf nur Buchstaben, Striche und Unterstriche enthalten.',
    'alpha_num' => 'Das Feld :attribute darf nur Buchstaben und Zahlen enthalten.',
    'array' => 'Das Feld :attribute kann nur ein Array enthalten.',
    'before' => 'Das Feld :attribute muss ein Datum früher als :date enthalten.',
    'before_or_equal' => 'Das Feld :attribute muss ein Datum früher oder gleich :date enthalten.',
    'between' => [
        'numeric' => 'Das Feld :attribute muss einen Wert zwischen :min und :max enthalten.',
        'file' => 'Die Dateigröße von :attribute muss zwischen :min und :max kilobytes liegen.',
        'string' => 'Die Zeichenkette :attribute muss zwischen :min und :max Zeichen lang sein.',
        'array' => 'Das Array :attribute muss mindestens :min und höchsten :max Elemente ethalten.',
    ],
    'boolean' => 'Das Feld :attribute darf nur die Werte true und false annehmen.',
    'confirmed' => 'Die Wiederholung von :attribute stimmt nicht überein.',
    'current_password' => 'Das Passwort ist falsch.',
    'date' => 'Das Feld :attribute enthält kein gültiges Datum.',
    'date_equals' => 'Das Feld :attribute muss ein Datum identisch mit :date enthalten.',
    'date_format' => 'Das Datum in :attribute bestitzt ein anderes Format als :format.',
    'different' => 'Die Felder :attribute und :other müssen sich unterscheiden.',
    'digits' => 'Die Zahl in :attribute muss aus exakt :digits Ziffern bestehen.',
    'digits_between' => 'Die Zahl in :attribute muss zwischen :min und :max Ziffern lang sein.',
    'dimensions' => 'Das Bild :attribute hat eine ungültige Größe (Dimensionen).',
    'distinct' => 'Der Wert :attribute ist nicht eindeutig.',
    'email' => 'Das Feld :attribute muss eine gültige E-Mail Adresse beinhalten.',
    'ends_with' => 'Der Wert im Feld :attribute muss mit einem der folgenden Zeichen enden: :values.',
    'exists' => 'Der ausgewählte Wert :attribute ist ungültig.',
    'file' => 'Der Wert in :attribute muss einer Datei entsprechen.',
    'filled' => 'Das Feld :attribute muss einen Wert beinhalte.',
    'gt' => [
        'numeric' => 'Der Wert in :attribute muss größer als :value sein.',
        'file' => 'Die Größe von :attribute muss mindestens :value kilobytes betragen.',
        'string' => 'Die Zeichenkette in :attribute muss mehr als :value Zeichen beinhalten.',
        'array' => 'Das Array in :attribute muss mindestens aus :value Elementen bestehen.',
    ],
    'gte' => [
        'numeric' => 'Das Feld :attribute muss einen Wert größer oder gleich :value beinhalten.',
        'file' => 'Die Datei :attribute muss mindestend eine Größe von :value Kilobytes besitzen.',
        'string' => 'Die Zeichenkette :attribute muss muss aus mindestens :value Zeichen bestehen.',
        'array' => 'Das Array :attribute muss mindestens über :value Elemente verfügen.',
    ],
    'image' => 'Das Feld :attribute muss ein Bild beinhalten.',
    'in' => 'Das ausgewählte Element :attribute ist ungültig.',
    'in_array' => 'Das Feld :attribute gibt es nicht in :other.',
    'integer' => 'Der Wert im Feld :attribute muss eine Ganzzahl sein.',
    'ip' => 'Der Wert im Feld :attribute muss eine gültige IP Adresse sein.',
    'ipv4' => 'Der Wert im Feld :attribute muss eine gültige IPv4 Adresse sein.',
    'ipv6' => 'Der Wert im Feld :attribute muss eine gültige IPv6 Adresse sein.',
    'json' => 'Das Feld :attribute muss Daten im JSON-Format enthalten.',
    'lt' => [
        'numeric' => 'Der Wert im Feld :attribute muss kleiner als :value sein.',
        'file' => 'Die Größer der Datei :attribute muss kleiner als :value Kilobytes sein.',
        'string' => 'Die Länge der Zeichenkette :attribute muss kleiner als :value sein.',
        'array' => 'Das Array :attribute muss aus weniger als :value Elementen bestehen.',
    ],
    'lte' => [
        'numeric' => 'Die Zahl :attribute muss kleiner oder gleich :value sein.',
        'file' => 'Die Dateigröße von :attribute darf maximal :value Kilobytes betragen.',
        'string' => 'Die Zeichenkette :attribute darf aus maximal :value Zeichen bestehen.',
        'array' => 'Das Array :attribute darf maximal :value Elemente beinhalten.',
    ],
    'max' => [
        'numeric' => 'Die Zahl :attribute darf nicht größer als :max sein.',
        'file' => 'Die Datei :attribute darf maximal :max Kilobytes groß sein.',
        'string' => 'Die Zeichenkette :attribute darf aus maximal :max Zeichen bestehen.',
        'array' => 'Das Array :attribute darf nicht mehr als :max Elemente beinhalten.',
    ],
    'mimes' => 'Die Datei :attribute muss vom Typ :values sein.',
    'mimetypes' => 'Die Datei :attribute muss einer der folgenden Typen sein: :values.',
    'min' => [
        'numeric' => 'Die Zahl :attribute darf minimal dem Wert :min entsprechen.',
        'file' => 'Die Datei :attribute muss mindestens :min Kilobytes groß sein.',
        'string' => 'Die Zeichenkette :attribute muss mindestens eine Länge von :min haben.',
        'array' => 'Das Array :attribute muss über mindestens :min Elemente verfügen.',
    ],
    'multiple_of' => 'Der Wert :attribute muss ein Vielfaches von :value sein.',
    'not_in' => 'Der ausgewählte Wert :attribute ist ungültig.',
    'not_regex' => 'Das Format von :attribute ist ungültig.',
    'numeric' => 'Der Wert :attribute muss eine Nummer sein.',
    'password' => 'Das Passwort ist nicht richtig.',
    'present' => 'Das Feld :attribute muss ausgefüllt sein.',
    'regex' => 'Das Format von :attribute ist ungültig.',
    'required' => 'Das Feld :attribute muss ausgefüllt werden.',
    'required_if' => 'Das Feld :attribute muss ausgefüllt werden, wenn das Feld :other den Wert :value hat.',
    'required_unless' => 'Das Feld :attribute muss ausgefüllt werden, es sei denn :other hat einen der Werte :values.',
    'required_with' => 'Das Feld :attribute muss ausgefüllt weden, wenn einer der Werte :values vorhanden ist.',
    'required_with_all' => 'Das Feld :attribute muss werdenm wenn alle der Werte :values vorhanden sind.',
    'required_without' => 'Das Feld :attribute muss ausgefüllt werden, wenn keiner der Werte :values vorhanden ist.',
    'required_without_all' => 'Das Feld :attribute muss ausgefüllt werden, wenn keiner der Werte :values vorhanden ist.',
    'prohibited' => 'Das Ausfüllen des Feldes :attribute ist verboten.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'Das Ausfüllen des Feldes :attribute ist verboten, es sei denn :other hat einen der Werte :values.',
    'same' => 'Die Felder :attribute und :other müssen übereinstimmen.',
    'size' => [
        'numeric' => 'Die Zahl im Feld :attribute muss den Wert :size haben.',
        'file' => 'Die Datei :attribute muss genau :size Kilobytes groß sein.',
        'string' => 'Die Zeichenkette :attribute muss aus exakt :size Zeichen bestehen.',
        'array' => 'Das Array :attribute muss über genau :size verfügen.',
    ],
    'starts_with' => 'Der Wert :attribute muss mit einem der folgenden Werte starten: :values.',
    'string' => 'Der Wert in Feld :attribute muss ein String sein.',
    'timezone' => 'Der Wert in :attribute muss der Benennung einer Zeitzone entsprechen.',
    'unique' => 'Der Wert :attribute ist bereits vorhanden.',
    'uploaded' => 'Der Upload von :attribute schlug fehl.',
    'url' => 'Der Wert in :attribute muss eine gültige URL sein.',
    'uuid' => 'Der Wert in :attribute muss eine gültige UUID sein.',
    'tel' => 'Das Feld :attribute muss eine gültige Telefonnummer enthalten.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
     */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
     */

    'attributes' => [
        "firstname" => "Vorname",
        "lastname" => "Nachname",
        "street" => "Straße",
        "street_number" => "Hausnummer (Nr.)",
        "zip" => "Postleitzahl (PLZ)",
        "city" => "Stadt",
        "tel" => "Telefonnummer",
        "company" => "Firma",
        "industry" => "Branche",
        "homepage" => "Homepage",
        "tax_id" => "Steuernummer",
        "company_about" => "Über die Firma",
        "searchwords" => "Suchworte",
        "gmaps_user" => "google Maps Benutzer",
        "gmaps_url" => "Link zur Bewertungsseite",
        "paypal_user" => "Paypal Konto",
    ],

];
