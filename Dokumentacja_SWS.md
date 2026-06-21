## 1. Strona Tytułowa [SŻ]
**Dokumentacja Projektu: System Wydarzeń Sportowych (SWS)**
**Autor:** Sebastian Żaczkiewicz
**Link do repozytorium:** https://github.com/SebZak00/sws-projekt
**Wersja Live:** Brak (Środowisko deweloperskie)

## 2. Słownik pojęć [SŻ]
* **Wydarzenie** - zorganizowane zawody sportowe.
* **Rejestracja** - proces zgłaszania uczestnika do wydarzenia.
* **MVP** - minimalny zestaw funkcji niezbędny do uruchomienia aplikacji.
* **RBAC** - Role-Based Access Control (Kontrola dostępu oparta na rolach).

## 3. Cel projektu i odbiorca docelowy [SŻ]
Celem projektu jest stworzenie aplikacji webowej umożliwiającej organizatorom tworzenie wydarzeń, a uczestnikom wygodne zapisywanie się do udziału w nich. System redukuje ręczne procesy papierowe. Odbiorcą docelowym systemu są lokalni organizatorzy zawodów sportowych (osoby techniczne i nietechniczne) oraz amatorscy zawodnicy.

## 4. Architektura i wzorce [SŻ]
System oparty jest na architekturze monolitycznej wykorzystującej wzorzec MVC (Model-View-Controller). Backend obsługiwany jest przez framework Laravel 11 (PHP), bazę danych MySQL oraz ORM Eloquent.

## 5. Wymagania funkcjonalne i niefunkcjonalne [SŻ]
**Wymagania Funkcjonalne:**
1. Tworzenie wydarzenia: Organizator może dodać wydarzenie (tytuł, data, limit).
2. Zapisy: Uczestnik może zapisać się na wydarzenie i z niego zrezygnować.
3. Zarządzanie uprawnieniami: Administrator może nadawać i zmieniać role użytkowników.

**Wymagania Niefunkcjonalne:**
1. Dostępność serwisu na poziomie 99%. 
2. Pełna responsywność widoków na urządzeniach mobilnych (Tailwind CSS).

## 6. Ograniczenia sprzętowe i oprogramowania [SŻ]
* **Sprzęt (Serwer):** Do uruchomienia środowiska produkcyjnego wystarczy podstawowy serwer VPS (np. 1 vCPU, 1GB RAM). 
* **Sprzęt (Klient):** System nie nakłada żadnych ograniczeń sprzętowych na użytkownika końcowego – wystarczy dowolne urządzenie (PC, smartfon) z dostępem do Internetu.
* **Oprogramowanie:** Wymagane środowisko to PHP w wersji min. 8.2 oraz relacyjna baza danych MySQL 8.0. Użytkownik potrzebuje jedynie nowoczesnej przeglądarki internetowej.
* **Biznesowe:** Zgodnie z ograniczeniem wersji MVP zrezygnowano z zewnętrznych systemów płatności na rzecz uproszczonej rejestracji.

## 7. Użytkownicy i Aktorzy [SŻ]
W systemie wyróżniamy 3 główne role (aktorów):
* **Administrator:** Posiada dostęp do panelu zarządzania, nadaje role. Nie może tworzyć wydarzeń.
* **Organizator:** Użytkownik z podwyższonymi uprawnieniami, który ma wyłączny dostęp do formularza tworzenia nowych wydarzeń sportowych.
* **Użytkownik (Zawodnik):** Podstawowa rola po rejestracji. Przegląda wydarzenia, zapisuje się i rezygnuje z udziału.

## 8. Przypadki użycia [SŻ]
**a) Diagram Przypadków Użycia**
![Diagram Przypadków Użycia](img/diagram_przypadkow_uzycia.png)

**b) Scenariusz (Dla: Tworzenie nowego wydarzenia)**
* **Aktor Główny:** Organizator
* **Warunek wstępny:** Użytkownik jest zalogowany i posiada rolę "Organizator".
* **Kroki:**
  1. Organizator wybiera opcję "Dodaj Wydarzenie".
  2. System wyświetla pusty formularz.
  3. Organizator wypełnia pola: nazwa, data, limit miejsc i klika "Utwórz".
  4. System weryfikuje poprawność danych (np. czy limit > 0).
  5. System zapisuje wydarzenie w bazie i wyświetla komunikat o sukcesie.
* **Scenariusz alternatywny:** W kroku 4, jeśli dane są błędne (np. ujemny limit), system przerywa operację i wyświetla czerwone komunikaty o błędach nad formularzem.

## 9. Baza danych (Diagram struktury danych) [SŻ]
![Diagram ERD](img/diagram_erd.png)

## 10. Diagramy Sekwencji [SŻ]
**Zidentyfikowane w systemie diagramy sekwencji:**
1. Tworzenie nowego wydarzenia sportowego.
2. Logowanie i autoryzacja użytkownika.
3. Proces zapisu zawodnika na wydarzenie z weryfikacją limitu.
4. Zmiana roli użytkownika przez Administratora.

*Poniżej zamieszczono 1 wybrany diagram dla procesu: Tworzenie nowego wydarzenia sportowego*
![Diagram Sekwencji](img/diagram_sekwencji.png)

## 11. Diagramy Aktywności [SŻ]
**Zidentyfikowane w systemie diagramy aktywności:**
1. Nawigacja po dashboardzie i adaptacyjne ukrywanie przycisków w zależności od roli.
2. Proces wypełniania i walidacji formularza wydarzenia.
3. Ścieżka rejestracji nowego konta w systemie.

*Poniżej zamieszczono 1 wybrany diagram dla procesu: Nawigacja po dashboardzie.*
![Diagram Aktywności](img/diagram_aktywnosci.png)

## 12. Diagramy Stanów [SŻ]
**Zidentyfikowane w systemie stany dla obiektów:**
1. Rejestracja zawodnika (Oczekująca, Zatwierdzona, Odrzucona).
2. Wydarzenie sportowe (Szkic, Aktywne, Zakończone).
3. Konto użytkownika (Niezweryfikowane, Aktywne, Zablokowane).

*Poniżej zamieszczono 1 wybrany diagram dla obiektu: Rejestracja zawodnika.*
![Diagram Stanów](img/diagram_stanow.png)

## 13. Dokumentacja bezpieczeństwa (Opis teoretyczny) [SŻ]
* **Secure by Design:** System od samego początku projektowany jest z myślą o unikaniu luk bezpieczeństwa. Wymuszone jest wiązanie parametrów (Parameter Binding) przy kontakcie z bazą, co chroni przed SQL Injection. Hasła nigdy nie są przetrzymywane w tekście jawnym.
* **Zero Trust:** System operuje na zasadzie całkowitego braku zaufania. Każde, nawet najmniejsze żądanie HTTP musi zostać zweryfikowane pod kątem tożsamości żądającego i przypisanej mu roli. 
* **Privacy by Design:** Zgodnie z zasadą minimalizacji danych, aplikacja gromadzi wyłącznie dane absolutnie niezbędne do działania (imię/pseudonim i adres e-mail).

## 14. Dostępność (WCAG) [SŻ]
Aplikacja wspiera standard WCAG 2.1. Zastosowano semantyczny kod HTML5, znaczniki `aria-label` oraz zapewniono wysoki kontrast elementów interaktywnych (przycisków). Aplikację można w pełni obsługiwać za pomocą klawiatury (klawisz Tab).

## 15. Diagram Klas [SŻ]
![Diagram Klas](img/diagram_klas.png)

## 16. Kod SQL [SŻ]
**a) Standard SQL do tworzenia modelu bazy:**
```sql
CREATE TABLE users (id INTEGER PRIMARY KEY, name VARCHAR(255), email VARCHAR(255), password VARCHAR(255), role VARCHAR(20));
CREATE TABLE events (id INTEGER PRIMARY KEY, title VARCHAR(255), event_date TIMESTAMP, capacity INTEGER);
CREATE TABLE registrations (id INTEGER PRIMARY KEY, user_id INTEGER, event_id INTEGER);
```
**b) Dialekt SQL (MySQL - użyty w projekcie):**
```sql
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'organizator', 'uzytkownik') DEFAULT 'uzytkownik'
);
CREATE TABLE events (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    event_date DATETIME NOT NULL,
    capacity INT NOT NULL
);
CREATE TABLE registrations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    event_id BIGINT UNSIGNED NOT NULL
);
```

## 17. Przypadki Testowe [SŻ]
| ID | Nazwa testu | Warunki wstępne | Kroki do wykonania | Oczekiwany rezultat |
| :--- | :--- | :--- | :--- | :--- |
| **TC-01** | Dodanie wydarzenia | Użytkownik zalogowany z rolą Organizator | 1. Kliknij "+ Dodaj Wydarzenie"<br>2. Wypełnij Tytuł, Datę i Limit<br>3. Kliknij "Utwórz" | Pojawia się komunikat o sukcesie, wydarzenie jest na liście. |
| **TC-02** | Zapis na wydarzenie | Zalogowany, wydarzenie ma wolne miejsca | 1. Znajdź wydarzenie na liście<br>2. Kliknij "Zapisz się" | Komunikat o sukcesie, licznik miejsc rośnie, zmiana przycisku. |

## 18. Testy Jednostkowe [SŻ]
**Kod testów (PHPUnit):**
```php
<?php
namespace Tests\Unit;
use PHPUnit\Framework\TestCase;
use App\Models\Event;

class EventTest extends TestCase
{
    public function test_event_can_be_instantiated_with_capacity()
    {
        $event = new Event();
        $event->title = "Bieg Wiosenny";
        $event->capacity = 50;
        $this->assertEquals("Bieg Wiosenny", $event->title);
        $this->assertEquals(50, $event->capacity);
    }

    public function test_event_has_available_spots()
    {
        $event = new Event();
        $event->capacity = 10;
        $registeredUsersCount = 5; 
        $hasSpots = ($event->capacity - $registeredUsersCount) > 0;
        $this->assertTrue($hasSpots);
    }
}
```
**Zrzut ekranu po wywołaniu testów w konsoli:**
![Wynik testów PHPUnit](img/testy_konsola.png)

## 19. Diagram Komponentów i Wdrożenia [SŻ]
**Diagram Komponentów:**
![Diagram Komponentów](img/diagram_komponentow.png)

**Diagram Wdrożenia:**
![Diagram Wdrożenia](img/diagram_wdrozenia.png)

## 20. Instalacja i konfiguracja CI/CD [SŻ]
System korzysta z GitHub Actions do automatycznego testowania kodu (Continuous Integration).
**Plik .github/workflows/tests.yml:**
```yaml
name: Laravel Tests
on: [push, pull_request]
jobs:
  test:
    runs-on: ubuntu-latest
    steps:
    - uses: actions/checkout@v3
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
    - name: Install Dependencies
      run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
    - name: Execute tests via PHPUnit
      run: vendor/bin/phpunit
```
**Konfiguracja:** W środowisku deweloperskim uruchomienie następuje poprzez `composer install`, `npm install && npm run build`, `php artisan migrate` oraz włączenie serwera komendą `php artisan serve`.

## 21. Implementacja bezpieczeństwa w praktyce [SŻ]
Planowane mechanizmy zrealizowano za pomocą wbudowanych narzędzi frameworka:
* **Secure by Design:** Hasła przed zapisem są solone i hashowane wbudowanym algorytmem `Bcrypt`. Zastosowano ORM Eloquent korzystający pod maską z PDO.
* **Zero Trust (Praktyka):** Zbudowano niestandardowy komponent `RoleMiddleware.php`. Mechanizm ten wyłapuje każde żądanie HTTP, wyciąga obiekt zalogowanego użytkownika (`auth()->user()`) i sprawdza zawartość kolumny `role`. Jeśli zwykły Zawodnik wyśle sztuczne żądanie np. `POST /events` (przez Postmana), Middleware natychmiast zablokuje operację (Błąd 403 - Forbidden).

## 22. Podręcznik Użytkownika [SŻ]
**Spis treści całego podręcznika:**
1. Wstęp
2. Tworzenie konta i logowanie
3. Zarządzanie wydarzeniami
   3.1. Dodawanie nowego wydarzenia (Rola: Organizator)
   3.2. Przeglądanie listy wydarzeń
4. Partycypacja w wydarzeniach
   4.1. Zapisywanie się na wydarzenie
   4.2. Rezygnacja z udziału
5. Administracja systemem
   5.1. Zarządzanie rolami użytkowników (Rola: Admin)

**Szczegółowy opis wybranych sekcji (Zgodnie ze spisem):**

**Sekcja 3.1. Dodawanie nowego wydarzenia**
Aby dodać nowe wydarzenie, zaloguj się do systemu kontem z rolą Organizatora i przejdź do widoku głównego (Dashboard). W górnej części ekranu znajdź i kliknij zielony przycisk `+ Dodaj Wydarzenie`. Zostaniesz przeniesiony do formularza. Wypełnij wymagane pola: podaj czytelną nazwę, wybierz datę z systemowego kalendarza oraz określ maksymalny limit uczestników (musi to być liczba większa od zera). Po upewnieniu się, że dane są poprawne, kliknij niebieski przycisk `Utwórz wydarzenie`. System potwierdzi operację stosownym komunikatem, a nowe wydarzenie natychmiast pojawi się w katalogu.
![Formularz dodawania wydarzenia](img/formularz_organizator.png)

**Sekcja 4.1. Zapisywanie się na wydarzenie**
Zapisy na wydarzenia są niezwykle proste. Na głównym ekranie zlokalizuj interesujące Cię wydarzenie w tabeli. Sprawdź kolumnę `Miejsca`, aby upewnić się, że limit uczestników nie został wyczerpany. Jeśli miejsca są dostępne, w kolumnie `Akcja` kliknij przycisk `Zapisz się`. System automatycznie przypisze Twoje konto do listy startowej i zaktualizuje licznik wolnych miejsc. Przycisk zmieni swój kolor i etykietę na `Wypisz się`, co umożliwi Ci ewentualną rezygnację w przyszłości.
![Widok z panelu zawodnika](img/widok_zawodnik.png)

**Sekcja 5.1. Zarządzanie rolami użytkowników**
Logując się na konto o uprawnieniach Administratora, zyskujesz dostęp do dedykowanego panelu sterowania. Na stronie głównej kliknij fioletowy przycisk `Zarządzaj Użytkownikami (Admin)`. Ukaże się zestawienie wszystkich zarejestrowanych kont. Aby zmienić uprawnienia wybranej osoby, zlokalizuj jej wiersz w tabeli, wybierz z listy rozwijanej odpowiednią rolę (Użytkownik, Organizator lub Admin), a następnie potwierdź wybór niebieskim przyciskiem `Zapisz`. Zmiany są uwzględniane w systemie natychmiastowo.
![Widok z panelu administratora](img/widok_admin.png)