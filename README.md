### Instrukcja uruchamiania projektu

1. Sprawdź czy porty 80 i 443 są wolne
```bash
    sudo lsof -i :80
    sudo lsof -i :443
```
2. Zatrzymanie Apache jeśli zajęte
```bash
  sudo systemctl stop apache2 
```

3. Sklonuj repozytorium
```bash
   git clone https://github.com/zawadkaprzemek/codeone_rekrutacja
   cd codeone_rekrutacja
```

4. Zbuduj obrazy Dockerowe i je uruchom
```bash
   docker compose up --build
```

5. Załaduj początkowe dane do bazy danych
```bash
  docker compose run --rm payments-svc bash
  php bin/console doctrine:schema:update --force
  php bin/console doctrine:fixtures:load -y 
```

6. Otwórz stronę w swojej przeglądarce
   http://localhost:8080/