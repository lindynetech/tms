FROM node:20-alpine

WORKDIR /app

RUN apk add --no-cache \
    bash \
    curl

COPY package*.json ./

RUN npm ci && npm cache clean --force

COPY . .

RUN npm run build

RUN npm prune --production

RUN addgroup -g 1001 -S nodejs && \
    adduser -S nodejs -u 1001

RUN chown -R nodejs:nodejs /app

USER nodejs

EXPOSE 3000

ENV NODE_ENV=production

CMD ["node", "dist/server.js"]
