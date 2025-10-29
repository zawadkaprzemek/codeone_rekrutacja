FROM node:20

WORKDIR /app

# Najpierw kopiujemy tylko package*.json, żeby cache działało szybciej
COPY package*.json ./

# Instalujemy zależności
RUN npm install

# Teraz dopiero kopiujemy resztę projektu
COPY . .

# Otwieramy port 5173 (dla Vite)
EXPOSE 5173

# Uruchamiamy serwer Vite
CMD ["npm", "run", "dev", "--", "--host", "0.0.0.0", "--port", "5173"]
