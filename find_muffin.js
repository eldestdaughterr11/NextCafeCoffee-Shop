const { PrismaClient } = require('@prisma/client');
const prisma = new PrismaClient();
async function main() {
  const p = await (prisma.product.findMany());
  for (const x of p) {
    if (x.name.includes("Muffin")) {
      console.log(x.name, '||', x.image);
    }
  }
}
main().finally(() => prisma.$disconnect());
