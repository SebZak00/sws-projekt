# System Wydarzeń Sportowych (SWS)

Projekt systemu informatycznego do zarządzania wydarzeniami sportowymi, realizowany w ramach przedmiotu "Projekt Systemu". Aplikacja pozwala na bezpieczną rejestrację użytkowników, tworzenie wydarzeń sportowych oraz zapisywanie się na nie z uwzględnieniem limitu miejsc.

## Technologie i Architektura
Projekt został zrealizowany w oparciu o architekturę MVC (Model-View-Controller).
* **Backend:** PHP 8.2, Laravel 11
* **Frontend:** Blade, Tailwind CSS (pakiet Laravel Breeze)
* **Baza danych:** MySQL (z wykorzystaniem mechanizmu migracji oraz Eloquent ORM)
* **Kontrola wersji i CI/CD:** Git, GitHub Actions

## Uruchomienie lokalne (Środowisko deweloperskie)

Aby uruchomić projekt na własnym komputerze, postępuj zgodnie z poniższymi krokami:

1. Sklonuj repozytorium do wybranego folderu:
   git clone https://github.com/SebZak00/sws-projekt.git  
   cd sws-projekt  

2. Zainstaluj niezbędne pakiety PHP oraz Node.js:
   composer install  
   npm install && npm run build  

3. Skonfiguruj plik środowiskowy:
   * Skopiuj plik `.env.example` i zmień jego nazwę na `.env`.  
   * Wygeneruj unikalny klucz aplikacji:  
     php artisan key:generate  
   * Otwórz plik `.env` i uzupełnij dane dostępowe do swojej bazy danych MySQL (np. XAMPP):  
     DB_CONNECTION=mysql  
     DB_HOST=127.0.0.1  
     DB_PORT=3306  
     DB_DATABASE=sws_db  
     DB_USERNAME=root  
     DB_PASSWORD=  

4. Uruchom migracje, aby zbudować strukturę bazy danych:
   php artisan migrate

5. Uruchom wbudowany serwer deweloperski:
   php artisan serve
   
Aplikacja będzie dostępna pod adresem: http://127.0.0.1:8000

---

## Uruchomienie w środowisku produkcyjnym (Instrukcja wdrożenia)

Wdrożenie aplikacji na serwerze produkcyjnym wymaga zastosowania dodatkowych kroków optymalizacyjnych i polityki bezpieczeństwa:

1. **Zabezpieczenie konfiguracji środowiskowej:**
   W pliku `.env` na serwerze produkcyjnym należy bezwzględnie ustawić tryb produkcji oraz wyłączyć wyświetlanie błędów:  
   APP_ENV=production  
   APP_DEBUG=false  

2. **Optymalizacja instalacji zależności:**
   Pakiety Composera muszą zostać zainstalowane z wykluczeniem paczek deweloperskich oraz z optymalizacją autoloadera:  
   composer install --optimize-autoloader --no-dev

3. **Cache'owanie aplikacji (Wydajność):**
   Aby drastycznie przyspieszyć działanie systemu, należy wygenerować pliki cache dla konfiguracji, ścieżek routingu oraz widoków:<br> 
   php artisan config:cache<br>
   php artisan route:cache<br>
   php artisan view:cache<br>

4. **Kompilacja i wersjonowanie zasobów Frontendowych:**
   Zasoby statyczne (CSS/JS) należy zminifikować do wersji produkcyjnej, aby zredukować ich rozmiar:<br>
   npm install<br>
   npm run build

## Licencja
Projekt udostępniany na darmowej licencji **MIT**.