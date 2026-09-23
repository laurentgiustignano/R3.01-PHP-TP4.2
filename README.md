# API Panier

API REST de gestion de panier d'achat. Les données sont stockées en mémoire (pas de persistance fichier).

## Démarrage

```bash
php -S localhost:8765 -t public/
```

## Endpoints

### GET /api/cart

Récupère la liste des produits dans le panier.

**Réponse 200 :**

```json
{
  "products": [
    { "name": "pizza", "quantity": 2 },
    { "name": "soda", "quantity": 1 }
  ]
}
```

Panier vide :

```json
{ "products": [] }
```

---

### POST /api/cart

Ajoute un produit au panier.

**Corps requis :**

```json
{
  "product": "pizza",
  "quantity": 2
}
```

**Réponse 201 :**

```json
{
  "message": "Produit ajouté",
  "product": "pizza",
  "quantity": 2
}
```

**Réponse 400** (validation échouée) :

```json
{
  "error": "Corps requis: {\"product\": \"nom\", \"quantity\": nombre}"
}
```

ou

```json
{
  "error": "product doit être une chaîne et quantity un entier positif"
}
```

**Réponse 405** (méthode incorrecte) :

```json
{
  "error": "Méthode non autorisée. Utilisez GET ou POST"
}
```

---

### DELETE /api/cart/{product}

Supprime un produit du panier.

**Exemple :** `DELETE /api/cart/pizza`

**Réponse 200 :**

```json
{
  "message": "Produit 'pizza' supprimé"
}
```

**Réponse 404** (produit non trouvé) :

```json
{
  "error": "Produit 'pizza' non trouvé dans le panier"
}
```

**Réponse 405** (méthode incorrecte) :

```json
{
  "error": "Méthode non autorisée. Utilisez DELETE"
}
```

---

### GET /api/cart/summary

Récupère un résumé du panier.

**Réponse 200 :**

```json
{
  "totalProducts": 2,
  "totalItems": 5
}
```

`totalProducts` : nombre de produits distincts.
`totalItems` : somme de toutes les quantités.

**Réponse 405** (méthode incorrecte) :

```json
{
  "error": "Méthode non autorisée. Utilisez GET"
}
```

---

### Route non trouvée

**Réponse 404 :**

```json
{
  "error": "Route non trouvée. Endpoints disponibles: GET/POST /api/cart, DELETE /api/cart/{product}, GET /api/cart/summary"
}
```

## Codes HTTP

| Code | Signification |
|------|--------------|
| 200  | Succès |
| 201  | Produit ajouté |
| 400  | Requête invalide |
| 404  | Route ou produit non trouvé |
| 405  | Méthode HTTP non autorisée |
